//Loading Screen
$(window).on("load", function() {
    $("body").addClass("loaded");
});

//Date Picker
//Date Joined - (Admin)
$(function() {
    $("#date_joined").datepicker({
        maxDate: "+0D",
        dateFormat: "yy-mm-dd",
        showAnim: "drop",
        changeMonth: true,
        changeYear: true,
    });
});

// Holiday Date - (Admin)
$(function() {
    $("#holiday_date").datepicker({
        dateFormat: "yy-mm-dd",
        showAnim: "drop",
        changeMonth: true,
        changeYear: true,
    });
});

//Disable Weekends & Holidays
function setHoliDays(date) {
    var holidays = jsbinder.holidays;
    var day = date.getDay();

    if (day == 0 || day == 6) {
        return [false, "weekends"];
    }

    for (i = 0; i < holidays.length; i++) {
        var holiday = new Date(Date.parse(holidays[i]));

        var holidaydate = holiday.getDate();
        var holidaymonth = holiday.getMonth();
        var holidayyear = holiday.getFullYear();

        if (
            date.getFullYear() == holidayyear &&
            date.getMonth() == holidaymonth &&
            date.getDate() == holidaydate
        ) {
            return [false, "holidays"];
        }
    }
    return [true, ""];
}

//Apply Leave DatePicker - From & To - (Employees)
$(function() {
    $("#leave_type_id")
        .on("change", function() {
            var type = $("#leave_type_id").val();

            $("#from, #to").datepicker("destroy");

            if (type == 1 || type == "Annual Leave") {
                if (type != null) {
                    if (type == 1 || type == 2 || type == 3 || type == 4) {
                        $("#from, #to, #days_taken").val(null);
                    }
                }

                //From - Annual
                $("#from").datepicker({
                    dateFormat: "yy-mm-dd",
                    showOnFocus: false,
                    beforeShowDay: setHoliDays,
                    pickerClass: "noPrevNext",
                    defaultDate: "+1D",
                    changeMonth: true,
                    numberOfMonths: 2,
                    showAnim: "drop",
                    showOtherMonths: true,
                    minDate: "+1D",
                    maxDate: "+1Y",
                    onSelect: function(dateStr) {
                        var min = $(this).datepicker("getDate");
                        $("#to").datepicker("option", "minDate", min || "0");
                        datepicked();
                    },
                });

                //To - Annual
                $("#to").datepicker({
                    dateFormat: "yy-mm-dd",
                    showOnFocus: false,
                    beforeShowDay: setHoliDays,
                    pickerClass: "noPrevNext",
                    numberOfMonths: 2,
                    changeMonth: true,
                    defaultDate: "+1D",
                    showAnim: "drop",
                    showOtherMonths: true,
                    minDate: "0",
                    maxDate: "+1Y",
                    onSelect: function(dateStr) {
                        var max = $(this).datepicker("getDate");
                        $("#from").datepicker(
                            "option",
                            "maxDate",
                            max || "+1Y"
                        );
                        datepicked();
                    },
                });
            } else {
                if (type != null) {
                    if (type == 1 || type == 2 || type == 3 || type == 4) {
                        $("#from, #to, #days_taken").val(null);
                    }
                }
                //From
                $("#from").datepicker({
                    dateFormat: "yy-mm-dd",
                    showOnFocus: false,
                    beforeShowDay: setHoliDays,
                    pickerClass: "noPrevNext",
                    defaultDate: "+1D",
                    changeMonth: true,
                    numberOfMonths: 2,
                    showAnim: "drop",
                    showOtherMonths: true,
                    maxDate: "+1Y",
                    onSelect: function(dateStr) {
                        var min = $(this).datepicker("getDate");
                        $("#to").datepicker("option", "minDate", min || "0");
                        datepicked();
                    },
                });
                //To
                $("#to").datepicker({
                    dateFormat: "yy-mm-dd",
                    showOnFocus: false,
                    beforeShowDay: setHoliDays,
                    pickerClass: "noPrevNext",
                    numberOfMonths: 2,
                    changeMonth: true,
                    defaultDate: "+1D",
                    showAnim: "drop",
                    showOtherMonths: true,
                    maxDate: "+1Y",

                    onSelect: function(dateStr) {
                        var min = $(this).datepicker("getDate");
                        $("#to").datepicker("option", "minDate", min || "0");
                        datepicked();
                    },
                });
            }
            $("#from, #to").datepicker("refresh");
        })
        .trigger("change");
});

// Leave Application Logic
var datepicked = function() {
    var from = $("#from");
    var to = $("#to");
    var days_taken = $("#days_taken");

    var startDate = from.datepicker("getDate");
    var endDate = to.datepicker("getDate");

    // Validate input
    if (endDate && startDate) {
        // Calculate days between dates
        var millisecondsPerDay = 86400 * 1000; // Day in milliseconds
        startDate.setHours(0, 0, 0, 1); // Start just after midnight
        endDate.setHours(23, 59, 59, 999); // End just before midnight
        var diff = endDate - startDate; // Milliseconds between datetime objects
        var days = Math.ceil(diff / millisecondsPerDay);

        // Subtract two weekend days for every week in between
        var weeks = Math.floor(days / 7);
        var days = days - weeks * 2;

        // Handle special cases
        var startDay = startDate.getDay();
        var endDay = endDate.getDay();

        // Remove weekend not previously removed.
        if (startDay - endDay > 1) var days = days - 2;

        // Remove start day if span starts on Sunday but ends before Saturday
        if (startDay == 0 && endDay != 6) var days = days - 1;

        // Remove end day if span ends on Saturday but starts after Sunday
        if (endDay == 6 && startDay != 0) var days = days - 1;

        //Holidays Check
        var holidays = jsbinder.holidays;
        var d1 = new Date(Date.parse(startDate));
        var d2 = new Date(Date.parse(endDate));
        var total_holidays = 0;

        for (i = 0; i < holidays.length; i++) {
            var d3 = new Date(Date.parse(holidays[i]));

            if (d3.getTime() <= d2.getTime() && d3.getTime() >= d1.getTime()) {
                total_holidays++;
            }
        }

        days = days - total_holidays;

        if (days == 1) {
            $("#morning").prop("disabled", false);
            $("#evening").prop("disabled", false);
        } else {
            $("#morning").prop("disabled", true);
            $("#evening").prop("disabled", true);
            $("#morning").prop("checked", false);
            $("#evening").prop("checked", false);
        }

        days_taken.val(days);
    }
};

//Live Clock
function startTime() {
    var today = new Date();

    var date = today.toDateString();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);

    $("#clock").html(h + ":" + m + ":" + s);
    $("#date").html(date);

    var t = setTimeout(startTime, 500);
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    } // add zero in front of numbers < 10
    return i;
}

//Tables
$(function() {
    $("table.container").on("click", "tr.table-tr", function() {
        window.location = $(this).data("url");
    });
});

//Phone Mask
$(function() {
    $("#phoneNum").inputmask();
});

//IC Mask
$(function() {
    $("#ic").inputmask();
});


//File Upload Custom Script
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$("#clear").on("click", function() {
    $("#file").val('').change()
});

$(function() {
    // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastTab', $(this).attr('href'));
    });

    // go to the latest tab, if it exists:
    var lastTab = localStorage.getItem('lastTab');
    if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
    }
});

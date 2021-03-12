// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

// Pie Chart of Gender Percentage
var ctx1 = document.getElementById("genderchart");
var male_count = jsbinder.dashboard_admins_array['male_count'];
var female_count = jsbinder.dashboard_admins_array['female_count'];
var gender_total = male_count + female_count;
var male_percentage = Math.round((male_count / gender_total) * 100);
var female_percentage = Math.round((female_count / gender_total) * 100);

var genderchart = new Chart(ctx1, {
    type: "doughnut",
    data: {
        labels: ["Male", "Female"],
        datasets: [
            {
                data: [male_percentage, female_percentage],
                backgroundColor: ["#3a8dde", "#f7525f"],
                hoverBackgroundColor: ["#1e4079", "#c5414c"],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "Employee Gender (%)",
            fontSize: 18,
            padding: 16,
        },
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                padding: 25,
                usePointStyle: true,
            },
        },
        cutoutPercentage: 50,
        animation: {
            onComplete: function () {
                if (gender_total === 0) {
                    document.getElementById("genderchartnone").style.display =
                        "block";
                    document.getElementById("genderchart").style.display =
                        "none";
                }
            },
        },
    },
});

// Pie Chart of Applications Status Percentage
var ctx2 = document.getElementById("applicationstatuschart");
var pending_count = jsbinder.dashboard_admins_array['pending_count'];
var approve_count = jsbinder.dashboard_admins_array['approve_count'];
var reject_count = jsbinder.dashboard_admins_array['reject_count'];
var application_total = pending_count + approve_count + reject_count;
var pending_percentage = Math.round((pending_count / application_total) * 100);
var approve_percentage = Math.round((approve_count / application_total) * 100);
var reject_percentage = Math.round((reject_count / application_total) * 100);

var applicationstatuschart = new Chart(ctx2, {
    type: "doughnut",
    data: {
        labels: ["Pending", "Approve", "Rejected"],
        datasets: [
            {
                data: [
                    pending_percentage,
                    approve_percentage,
                    reject_percentage,
                ],
                backgroundColor: ["#abeac6", "#2ecc71", "#1b7a43"],
                hoverBackgroundColor: ["#81e0a9", "#24a35a", "#12512d"],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "Application Overall Status (%)",
            fontSize: 18,
            padding: 16,
        },
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                padding: 22,
                usePointStyle: true,
            },
        },
        cutoutPercentage: 50,
        animation: {
            onComplete: function () {
                if (application_total === 0) {
                    document.getElementById(
                        "applicationstatuschartnone"
                    ).style.display = "block";
                    document.getElementById(
                        "applicationstatuschart"
                    ).style.display = "none";
                }
            },
        },
    },
});

// Pie Chart of Roles Percentage
var ctx3 = document.getElementById("roleschart");
var admin_count = jsbinder.dashboard_admins_array['admin_count'];
var employee_count = jsbinder.dashboard_admins_array['employee_count'];
var approver_count = jsbinder.dashboard_admins_array['approver_count'];
var roles_total = admin_count + employee_count + approver_count;
var admin_percentage = Math.round((admin_count / roles_total) * 100);
var employee_percentage = Math.round((employee_count / roles_total) * 100);
var approver_percentage = Math.round((approver_count / roles_total) * 100);

var roleschart = new Chart(ctx3, {
    type: "doughnut",
    data: {
        labels: ["Admin", "Employee", "Approver"],
        datasets: [
            {
                data: [
                    admin_percentage,
                    employee_percentage,
                    approver_percentage,
                ],
                backgroundColor: ["#fbff27", "#ff9f06", "#ff5000"],
                hoverBackgroundColor: ["#c8cc1f", "#cc7f04", "#cc4000"],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "Roles (%)",
            fontSize: 18,
            padding: 16,
        },
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                padding: 25,
                usePointStyle: true,
            },
        },
        cutoutPercentage: 50,
        animation: {
            onComplete: function () {
                if (roles_total === 0) {
                    document.getElementById("roleschartnone").style.display =
                        "block";
                    document.getElementById("roleschart").style.display =
                        "none";
                }
            },
        },
    },
});

// Pie Chart of Employee Status Percentage
var ctx4 = document.getElementById("empstatuschart");
var working_count = jsbinder.dashboard_admins_array['working_count'];
var resigned_count = jsbinder.dashboard_admins_array['resigned_count'];
var emp_status_total = working_count + resigned_count;
var working_percentage = Math.round((working_count / emp_status_total) * 100);
var resign_percentage = Math.round((resigned_count / emp_status_total) * 100);

var empstatuschart = new Chart(ctx4, {
    type: "doughnut",
    data: {
        labels: ["Working", "Resigned"],
        datasets: [
            {
                data: [working_percentage, resign_percentage],
                backgroundColor: ["#7acc28", "#3d6614"],
                hoverBackgroundColor: ["#5b991e", "#1e330a"],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "Employee Working Status (%)",
            fontSize: 18,
            padding: 16,
        },
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                padding: 25,
                usePointStyle: true,
            },
        },
        cutoutPercentage: 50,
        animation: {
            onComplete: function () {
                if (roles_total === 0) {
                    document.getElementById(
                        "empstatuschartnone"
                    ).style.display = "block";
                    document.getElementById("empstatuschart").style.display =
                        "none";
                }
            },
        },
    },
});

// Pie Chart of Individual Applications Status Percentage
var ctx5 = document.getElementById("thisyearapplicationchart");
var applications_count = jsbinder.dashboard_admins_array['applications_count'];
var applications_this_year_count = jsbinder.dashboard_admins_array['applications_this_year_count'];
var applications_other_year_count = jsbinder.dashboard_admins_array['applications_other_year_count'];

var this_year = Math.round(
    (applications_this_year_count / applications_count) * 100
);
var other_year = Math.round(
    (applications_other_year_count / applications_count) * 100
);

var thisyearapplicationchart = new Chart(ctx5, {
    type: "doughnut",
    data: {
        labels: ["Other Year", "This Year"],
        datasets: [
            {
                data: [other_year, this_year],
                backgroundColor: ["#c39bd3", "#9b59b6"],
                hoverBackgroundColor: ["#cdacda", "#7c4791"],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "Total Applications Applied (%)",
            fontSize: 18,
            padding: 16,
        },
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                padding: 25,
                usePointStyle: true,
            },
        },
        cutoutPercentage: 50,
        animation: {
            onComplete: function () {
                if (applications_count === 0) {
                    document.getElementById(
                        "thisyearapplicationchartnone"
                    ).style.display = "block";
                    document.getElementById(
                        "thisyearapplicationchart"
                    ).style.display = "none";
                }
            },
        },
    },
});

//--------------------------------------------------------------------------------------------------------

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + "").replace(",", "").replace(" ", "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

// Holiday Day Chart
var ctx6 = document.getElementById("daytotalchart");
var monday_count = jsbinder.dashboard_admins_array['monday_count'];
var tuesday_count = jsbinder.dashboard_admins_array['tuesday_count'];
var wednesday_count = jsbinder.dashboard_admins_array['wednesday_count'];
var thursday_count = jsbinder.dashboard_admins_array['thursday_count'];
var friday_count = jsbinder.dashboard_admins_array['friday_count'];
var saturday_count = jsbinder.dashboard_admins_array['saturday_count'];
var sunday_count = jsbinder.dashboard_admins_array['sunday_count'];
var highest_day_value = jsbinder.dashboard_admins_array['highest_day_value'];

var daytotalchart = new Chart(ctx6, {
    type: "bar",
    data: {
        labels: [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday",
        ],
        datasets: [
            {
                label: "Total",
                backgroundColor: "rgba(54, 162, 235, 0.2)",
                hoverBackgroundColor: "#2e59d9",
                borderColor: "rgb(54, 162, 235)",
                borderWidth: 1,
                data: [
                    monday_count,
                    tuesday_count,
                    wednesday_count,
                    thursday_count,
                    friday_count,
                    saturday_count,
                    sunday_count,
                ],
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "Holidays Day Chart",
            fontSize: 20,
        },
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0,
            },
        },
        datasets: {
            xAxes: [
                {
                    time: {
                        unit: "day",
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        maxTicksLimit: 6,
                    },
                    maxBarThickness: 80,
                },
            ],
            yAxes: [
                {
                    ticks: {
                        min: 0,
                        max: highest_day_value,
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            return number_format(value) + " Day(s)";
                        },
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2],
                    },
                },
            ],
        },
        legend: {
            display: false,
        },
        tooltips: {
            titleMarginBottom: 10,
            titleFontColor: "#6e707e",
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function (tooltipItem, chart) {
                    var datasetLabel =
                        chart.datasets[tooltipItem.datasetIndex].label || "";
                    return (
                        datasetLabel +
                        ": " +
                        number_format(tooltipItem.yLabel) +
                        " day(s)"
                    );
                },
            },
        },
    },
});

// Holiday Month Chart
var ctx7 = document.getElementById("monthtotalchart");
var january_count = jsbinder.dashboard_admins_array['january_count'];
var february_count = jsbinder.dashboard_admins_array['february_count'];
var march_count = jsbinder.dashboard_admins_array['march_count'];
var april_count = jsbinder.dashboard_admins_array['april_count'];
var may_count = jsbinder.dashboard_admins_array['may_count'];
var june_count = jsbinder.dashboard_admins_array['june_count'];
var july_count = jsbinder.dashboard_admins_array['july_count'];
var august_count = jsbinder.dashboard_admins_array['august_count'];
var september_count = jsbinder.dashboard_admins_array['september_count'];
var october_count = jsbinder.dashboard_admins_array['october_count'];
var november_count = jsbinder.dashboard_admins_array['november_count'];
var december_count = jsbinder.dashboard_admins_array['december_count'];

var highest_month_value = jsbinder.dashboard_admins_array['highest_month_value'];

var monthtotalchart = new Chart(ctx7, {
    type: "bar",
    data: {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ],
        datasets: [
            {
                label: "Total",
                backgroundColor: "rgba(255, 205, 86, 0.2)",
                hoverBackgroundColor: "rgba(255, 205, 86)",
                borderColor: "rgb(255, 205, 86)",
                borderWidth: 1,
                data: [
                    january_count,
                    february_count,
                    march_count,
                    april_count,
                    may_count,
                    june_count,
                    july_count,
                    august_count,
                    september_count,
                    october_count,
                    november_count,
                    december_count,
                ],
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "Holidays Month Chart",
            fontSize: 20,
        },
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0,
            },
        },
        datasets: {
            xAxes: [
                {
                    time: {
                        unit: "day",
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        maxTicksLimit: 6,
                    },
                    maxBarThickness: 50,
                },
            ],
            yAxes: [
                {
                    ticks: {
                        min: 0,
                        max: highest_month_value,
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function (value, index, values) {
                            return number_format(value) + " Day(s)";
                        },
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2],
                    },
                },
            ],
        },
        legend: {
            display: false,
        },
        tooltips: {
            titleMarginBottom: 10,
            titleFontColor: "#6e707e",
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function (tooltipItem, chart) {
                    var datasetLabel =
                        chart.datasets[tooltipItem.datasetIndex].label || "";
                    return (
                        datasetLabel +
                        ": " +
                        number_format(tooltipItem.yLabel) +
                        " day(s)"
                    );
                },
            },
        },
    },
});

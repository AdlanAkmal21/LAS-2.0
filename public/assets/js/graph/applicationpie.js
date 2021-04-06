// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = "'Nunito', sans-serif";
Chart.defaults.global.defaultFontColor = "#525252";


// Pie Chart of Application Summary
var ctx9 = document.getElementById("applicationsummarychart");

var annual_count = jsbinder.application_report_array["annual_count"];
var medical_count = jsbinder.application_report_array["medical_count"];
var emergency_count = jsbinder.application_report_array["emergency_count"];
var unrecorded_count = jsbinder.application_report_array["unrecorded_count"];

(annual_count == undefined) ? annual_count == 0 : '';
(medical_count == undefined) ? medical_count = 0 : '';
(emergency_count == undefined) ? emergency_count = 0 : '';
(unrecorded_count == undefined) ? unrecorded_count = 0 : '';

var application_type_total = annual_count + medical_count + emergency_count + unrecorded_count;

var applicationsummarychart = new Chart(ctx9, {
    type: "pie",
    data: {
        labels: ["Annual Leave", "Medical Leave", "Emergency Leave", "Unrecorded Leave"],
        datasets: [
            {
                data: [
                    annual_count,
                    medical_count,
                    emergency_count,
                    unrecorded_count,
                ],
                backgroundColor: ["#dc3545", "#ffc107", "#28a745", "#17a2b8"]
            },
        ],
    },
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        animation: {
            onComplete: function () {
                if (application_type_total === 0) {
                    document.getElementById(
                        "applicationsummarychartnone"
                    ).style.display = "block";
                    document.getElementById(
                        "applicationsummarychart"
                    ).style.display = "none";
                }
            },
        },
    },
});

// Pie Chart of Application Summary 2
var ctx10 = document.getElementById("applicationsummarychart2").getContext('2d');
var annual_monthly = jsbinder.monthly_array["annual_monthly"];
var medical_monthly = jsbinder.monthly_array["medical_monthly"];
var emergency_monthly = jsbinder.monthly_array["emergency_monthly"];
var unrecorded_monthly = jsbinder.monthly_array["unrecorded_monthly"];


var monthly_total = annual_monthly + medical_monthly + emergency_monthly + unrecorded_monthly;

var applicationsummarychart2 = new Chart(ctx10, {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Ma", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: 'Annual',
            backgroundColor: "#dc3545",
            data: [
                annual_monthly["jan"],
                annual_monthly["feb"],
                annual_monthly["mar"],
                annual_monthly["apr"],
                annual_monthly["may"],
                annual_monthly["jun"],
                annual_monthly["jul"],
                annual_monthly["aug"],
                annual_monthly["sep"],
                annual_monthly["oct"],
                annual_monthly["nov"],
                annual_monthly["dec"],
            ],
        }, {
            label: 'Medical',
            backgroundColor: "#ffc107",
            data: [
                medical_monthly["jan"],
                medical_monthly["feb"],
                medical_monthly["mar"],
                medical_monthly["apr"],
                medical_monthly["may"],
                medical_monthly["jun"],
                medical_monthly["jul"],
                medical_monthly["aug"],
                medical_monthly["sep"],
                medical_monthly["oct"],
                medical_monthly["nov"],
                medical_monthly["dec"],
            ],
        }, {
            label: 'Emergency',
            backgroundColor: "#28a745",
            data: [
                emergency_monthly["jan"],
                emergency_monthly["feb"],
                emergency_monthly["mar"],
                emergency_monthly["apr"],
                emergency_monthly["may"],
                emergency_monthly["jun"],
                emergency_monthly["jul"],
                emergency_monthly["aug"],
                emergency_monthly["sep"],
                emergency_monthly["oct"],
                emergency_monthly["nov"],
                emergency_monthly["dec"],
            ],
        }, {
            label: 'Unrecorded',
            backgroundColor: "#17a2b8",
            data: [
                unrecorded_monthly["jan"],
                unrecorded_monthly["feb"],
                unrecorded_monthly["mar"],
                unrecorded_monthly["apr"],
                unrecorded_monthly["may"],
                unrecorded_monthly["jun"],
                unrecorded_monthly["jul"],
                unrecorded_monthly["aug"],
                unrecorded_monthly["sep"],
                unrecorded_monthly["oct"],
                unrecorded_monthly["nov"],
                unrecorded_monthly["dec"],
            ],
        }],
    },
    options: {
        tooltips: {
            displayColors: true,
            callbacks: {
                mode: 'x',
            },
        },
        scales: {
            xAxes: [{
                stacked: true,
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                stacked: true,
                ticks: {
                    beginAtZero: true,
                },
                type: 'linear',
            }]
        },
        responsive: true,
        maintainAspectRatio: true,
        legend: {
            position: 'bottom',
            labels: {
                fontSize: 10,
            }
        },
        animation: {
            onComplete: function () {
                if (monthly_total === 0) {
                    document.getElementById(
                        "applicationsummarychart2none"
                    ).style.display = "block";
                    document.getElementById(
                        "applicationsummarychart2"
                    ).style.display = "none";
                }
            },
        },
    }
});


// Pie Chart of Leave Monthly (Type)
var ctx11 = document.getElementById("applicationsummarytypechart");
var monthly = jsbinder.type_array;
(monthly == undefined) ? monthly = 0 : '';

var applicationsummarytypechart = new Chart(ctx11, {
    type: "bar",
    data: {
        labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ],
        datasets: [
            {
                label: "Total",
                backgroundColor: "rgba(255, 205, 86, 0.2)",
                hoverBackgroundColor: "rgba(255, 205, 86)",
                borderColor: "rgb(255, 205, 86)",
                borderWidth: 1,
                data: [
                    monthly["jan"],
                    monthly["feb"],
                    monthly["mar"],
                    monthly["apr"],
                    monthly["may"],
                    monthly["jun"],
                    monthly["jul"],
                    monthly["aug"],
                    monthly["sep"],
                    monthly["oct"],
                    monthly["nov"],
                    monthly["dec"],
                ],
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "Leave Monthly Statistics",
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
                            return number_format(value) + " application(s)";
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
                        " application(s)"
                    );
                },
            },
        },
        animation: {
            onComplete: function () {
                if (monthly === 0) {
                    document.getElementById(
                        "applicationsummarytypechartnone"
                    ).style.display = "block";
                    document.getElementById(
                        "applicationsummarytypechart"
                    ).style.display = "none";
                }
            },
        },
    },
});

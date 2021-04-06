// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = "'Nunito', sans-serif";
Chart.defaults.global.defaultFontColor = "#525252";


// Pie Chart of Total Applications Percentage
var ctx8 = document.getElementById("individualappstatuschart");
var individual_pending_count = jsbinder.employee_report_array["pending_count"];
var individual_approve_count = jsbinder.employee_report_array["approve_count"];
var individual_reject_count = jsbinder.employee_report_array["reject_count"];

(individual_pending_count == undefined)?individual_pending_count = 0 : '';
(individual_approve_count == undefined)?individual_approve_count = 0 : '';
(individual_reject_count == undefined)?individual_reject_count = 0 : '';

var individual_application_total =
    individual_pending_count +
    individual_approve_count +
    individual_reject_count;

var individual_pending_percentage = Math.round(
    (individual_pending_count / individual_application_total) * 100
);
var individual_approve_percentage = Math.round(
    (individual_approve_count / individual_application_total) * 100
);
var individual_reject_percentage = Math.round(
    (individual_reject_count / individual_application_total) * 100
);

var individualappstatuschart = new Chart(ctx8, {
    type: "doughnut",
    data: {
        labels: ["Pending", "Approve", "Rejected"],
        datasets: [
            {
                data: [
                    individual_pending_percentage,
                    individual_approve_percentage,
                    individual_reject_percentage,
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
            text: "Individual Applications Status (%)",
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
                if (individual_application_total === 0) {
                    document.getElementById(
                        "individualappstatuschartnone"
                    ).style.display = "block";
                    document.getElementById(
                        "individualappstatuschart"
                    ).style.display = "none";
                }
            },
        },
    },
});

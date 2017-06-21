$(window).on('load', function() {
    getEnergyDataOfLastHours(1);
    chartjsDoughnutTest();
    updateChart();
});

var lineChart;

function addPoint() {
    console.log("button clicked");
    console.log(lineChart.data);

    var dataLength = lineChart.data.datasets[0].data.length;
    var labelsLength = lineChart.data.labels.length;

    lineChart.data.datasets[0].data[dataLength] = 60;
    lineChart.data.labels[labelsLength] = "August";

    console.log(lineChart.data);
    lineChart.update();
}

function chartjsDoughnutTest() {
    var data = {
        labels: [
            "Red",
            "Blue",
            "Yellow"
        ],
        datasets: [
            {
                data: [300, 50, 100],
                backgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56"
                ],
                hoverBackgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56"
                ]
            }
        ]
    };



    var ctx = document.querySelector("#chartjsTest2").getContext("2d");

    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: data
    });
}

function getAjaxTest() {
    $.ajax(
        {
            type : 'GET',
            url : 'api/test',
            dataType : 'JSON',
            success : function(response) {
                var ctx = document.querySelector("#chartjsTest").getContext("2d");

                var data = {
                    labels: response.data.timestamps,
                    datasets: [
                        {
                            label: "Gebruik",
                            responsive: true,
                            maintainAspectRatio: true,
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: response.data.usage,
                            spanGaps: false,
                        }
                    ]
                };

                lineChart = new Chart(ctx, {
                    type: 'line',
                    data: data
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function updateChart() {
    setInterval(function() {
        getLastEnergyUpdate();
    }, 10000);
}

function getLastEnergyUpdate() {
    $.ajax(
        {
            type : 'GET',
            url : 'api/energy/last',
            dataType : 'JSON',
            success : function(response) {
                $("#usage_now").html(response.data.usage[0] + " Wh");
                $("#solar_now").html(response.data.solar[0] + " Wh");
                $("#redelivery_now").html(response.data.redelivery[0] + " Wh");
                $("#intake_now").html(response.data.intake[0] + " Wh");

                var tempData = lineChart.data.datasets[0].data;
                var tempLabels = lineChart.data.labels;

                tempData.push(response.data.usage[0]);
                tempLabels.push(response.data.timestamps[0]);

                // Remove first element
                tempData.shift();
                tempLabels.shift();

                lineChart.data.datasets[0].data = tempData;
                lineChart.data.labels = tempLabels;

                lineChart.update();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function getEnergyDataOfLastHours(hours) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/energy/hours/' + hours,
            dataType : 'JSON',
            success : function(response) {
                var ctx = document.querySelector("#chartjsTest").getContext("2d");

                var data = {
                    labels: response.data.timestamps,
                    datasets: [
                        {
                            label: "Gebruik",
                            responsive: true,
                            maintainAspectRatio: false,
                            fill: true,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: response.data.usage,
                            spanGaps: false,
                        }
                    ]
                };

                lineChart = new Chart(ctx, {
                    type: 'line',
                    data: data
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

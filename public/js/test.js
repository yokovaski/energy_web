$(window).on('load', function() {
    getEnergyDataOfLastHours(24);
    getLastEnergyUpdate();
    // chartjsDoughnutTest();
    updateChart();
});

var dataEnergyUse = {
    labels: null,
    datasets: [
        {
            label: "Energieverbruik",
            responsive: true,
            maintainAspectRatio: false,
            fill: true,
            lineTension: 0.1,
            backgroundColor: "rgba(213, 236, 246, 0.4)",
            borderColor: "rgba(169, 225, 249, 1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(169, 225, 249, 1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(169, 225, 249, 1)",
            pointHoverBorderColor: "rgba(220,220,220, 1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: null,
            spanGaps: false,
        }
    ]
};

var dataEnergySolar = {
    labels: null,
    datasets: [
        {
            label: "Energieopwekking",
            responsive: true,
            maintainAspectRatio: false,
            fill: true,
            lineTension: 0.1,
            backgroundColor: "rgba(220, 239, 217, 0.4)",
            borderColor: "rgba(177, 237, 168, 1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(177, 237, 168, 1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(177, 237, 168, 1)",
            pointHoverBorderColor: "rgba(220,220,220, 1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: null,
            spanGaps: false,
        }
    ]
};

var dataEnergyRedelivery = {
    labels: null,
    datasets: [
        {
            label: "Energielevering",
            responsive: true,
            maintainAspectRatio: false,
            fill: true,
            lineTension: 0.1,
            backgroundColor: "rgba(255, 233, 165, 0.4)",
            borderColor: "rgba(255, 218, 107, 1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(255, 218, 107, 1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(255, 218, 107, 1)",
            pointHoverBorderColor: "rgba(220,220,220, 1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: null,
            spanGaps: false,
        }
    ]
};

var dataEnergyIntake = {
    labels: null,
    datasets: [
        {
            label: "Energieopname",
            responsive: true,
            maintainAspectRatio: false,
            fill: true,
            lineTension: 0.1,
            backgroundColor: "rgba(237, 206, 206,0.4)",
            borderColor: "rgba(247, 153, 153,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(247, 153, 153,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(247, 153, 153,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: null,
            spanGaps: false,
        }
    ]
};

var energyUseLineChart;
var energySolarLineChart;
var energyRedeliveryLineChart;
var energyIntakeLineChart;

var stopUpdating = false;

$(".chartRangeSelector").click(function(){
    $(".chartRangeSelector").removeClass('active');

    if($(this).hasClass('btn-week')) {
        $('.btn-week').addClass('active');
        getWeekChart();
        stopUpdating = true;
    } else if($(this).hasClass('btn-day')) {
        $('.btn-day').addClass('active');
        getDayChart();
        stopUpdating = true;
    } else if($(this).hasClass('btn-hour'))  {
        $('.btn-hour').addClass('active');
        getHourChart();
        stopUpdating = true;
    } else {
        $('.btn-now').addClass('active');
        getNowChart();
        stopUpdating = false;
    }
});

function getNowChart() {
    destroyCharts();
    getEnergyDataOfLastMinutes(10);
}

function getHourChart() {
    destroyCharts();
    getEnergyDataOfLastHours(1);
}

function getDayChart() {
    destroyCharts();
    getEnergyDataOfLastHours(24);
}

function getWeekChart() {
    destroyCharts();
    getEnergyDataOfLastHours(168);
}

function destroyCharts() {
    energyUseLineChart.destroy();
    energySolarLineChart.destroy();
    energyRedeliveryLineChart.destroy();
    energyIntakeLineChart.destroy();
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

function updateChart() {
    setInterval(function() {
        getLastEnergyUpdate();
    }, 10000);
}

function getLastEnergyUpdate() {
    if (stopUpdating) {
        return;
    }

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

                var tempData = energyUseLineChart.data.datasets[0].data;
                var tempLabels = energyUseLineChart.data.labels;

                tempData.push(response.data.usage[0]);
                tempLabels.push(response.data.timestamps[0]);

                // Remove first element
                tempData.shift();
                tempLabels.shift();

                energyUseLineChart.data.datasets[0].data = tempData;
                energyUseLineChart.data.labels = tempLabels;

                energyUseLineChart.update();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function getEnergyDataOfLastMinutes(minutes) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/energy/minutes/' + minutes,
            dataType : 'JSON',
            success : function(response) {
                var chartEnergyUse = document.querySelector("#chartEnergyUse").getContext("2d");

                dataEnergyUse.labels = response.data.timestamps;
                dataEnergyUse.datasets[0].data = response.data.usage;

                energyUseLineChart = new Chart(chartEnergyUse, {
                    type: 'line',
                    data: dataEnergyUse
                });

                var chartEnergySolar = document.querySelector("#chartEnergySolar").getContext("2d");

                dataEnergySolar.labels = response.data.timestamps;
                dataEnergySolar.datasets[0].data = response.data.solar;

                energySolarLineChart = new Chart(chartEnergySolar, {
                    type: 'line',
                    data: dataEnergySolar
                });

                var chartEnergyRedelivery = document.querySelector("#chartEnergyRedelivery").getContext("2d");

                dataEnergyRedelivery.labels = response.data.timestamps;
                dataEnergyRedelivery.datasets[0].data = response.data.redelivery;

                energyRedeliveryLineChart = new Chart(chartEnergyRedelivery, {
                    type: 'line',
                    data: dataEnergyRedelivery
                });

                var chartEnergyIntake = document.querySelector("#chartEnergyIntake").getContext("2d");

                dataEnergyIntake.labels = response.data.timestamps;
                dataEnergyIntake.datasets[0].data = response.data.intake;

                energyIntakeLineChart = new Chart(chartEnergyIntake, {
                    type: 'line',
                    data: dataEnergyIntake
                });
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
                var chartEnergyUse = document.querySelector("#chartEnergyUse").getContext("2d");

                dataEnergyUse.labels = response.data.timestamps;
                dataEnergyUse.datasets[0].data = response.data.usage;

                energyUseLineChart = new Chart(chartEnergyUse, {
                    type: 'line',
                    data: dataEnergyUse
                });

                var chartEnergySolar = document.querySelector("#chartEnergySolar").getContext("2d");

                dataEnergySolar.labels = response.data.timestamps;
                dataEnergySolar.datasets[0].data = response.data.solar;

                energySolarLineChart = new Chart(chartEnergySolar, {
                    type: 'line',
                    data: dataEnergySolar
                });

                var chartEnergyRedelivery = document.querySelector("#chartEnergyRedelivery").getContext("2d");

                dataEnergyRedelivery.labels = response.data.timestamps;
                dataEnergyRedelivery.datasets[0].data = response.data.redelivery;

                energyRedeliveryLineChart = new Chart(chartEnergyRedelivery, {
                    type: 'line',
                    data: dataEnergyRedelivery
                });

                var chartEnergyIntake = document.querySelector("#chartEnergyIntake").getContext("2d");

                dataEnergyIntake.labels = response.data.timestamps;
                dataEnergyIntake.datasets[0].data = response.data.intake;

                energyIntakeLineChart = new Chart(chartEnergyIntake, {
                    type: 'line',
                    data: dataEnergyIntake
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function getEnergyDataOfLastDays(days) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/energy/days/' + days,
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

                energyUseLineChart = new Chart(ctx, {
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
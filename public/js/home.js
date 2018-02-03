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

var stopUpdating = true;

$(window).on('load', function() {
    initCharts();
    getHourChart();
    updateChart();
});

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
    updateAllCharts('minutes', 10);
}

function getHourChart() {
    updateAllCharts('hours', 1);
}

function getDayChart() {
    updateAllCharts('hours', 24);
}

function getWeekChart() {
    updateAllCharts('hours', 168);
}

function destroyCharts() {
    energyUseLineChart.destroy();
    energySolarLineChart.destroy();
    energyRedeliveryLineChart.destroy();
    energyIntakeLineChart.destroy();
}

function updateChart() {
    setInterval(function() {
        getLastEnergyUpdate();
    }, 10000);
}

function initCharts() {
    energyUseLineChart = initChart("#chartEnergyUse", dataEnergyUse);
    energySolarLineChart = initChart("#chartEnergySolar", dataEnergySolar);
    energyRedeliveryLineChart = initChart("#chartEnergyRedelivery", dataEnergyRedelivery);
    energyIntakeLineChart = initChart("#chartEnergyIntake", dataEnergyIntake);
}

function initChart(canvasId, chartData) {
    var canvas = document.querySelector(canvasId).getContext("2d");

    chartData.labels = [];
    chartData.datasets[0].data = [];

    chart = new Chart(canvas, {
        type: 'line',
        data: chartData
    });

    return chart;
}

function updateAllCharts(timeUnit, time) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/average/energy/' + timeUnit + '/' + time,
            dataType : 'JSON',
            success : function(response) {
                var lastEnergyData = response.data;

                updateChartData(energyUseLineChart, lastEnergyData.usage, lastEnergyData.timestamps);
                updateChartData(energySolarLineChart, lastEnergyData.solar, lastEnergyData.timestamps);
                updateChartData(energyRedeliveryLineChart, lastEnergyData.redelivery, lastEnergyData.timestamps);
                updateChartData(energyIntakeLineChart, lastEnergyData.intake, lastEnergyData.timestamps);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function updateChartData(lineChart, data, labels) {
    lineChart.data.datasets[0].data = data;
    lineChart.data.labels = labels;

    lineChart.update();
}

function getLastEnergyUpdate() {
    $.ajax(
        {
            type : 'GET',
            url : 'api/average/energy/last',
            dataType : 'JSON',
            success : function(response) {
                $("#usage_now").html(response.data.usage[0] + " Wh");
                $("#solar_now").html(response.data.solar[0] + " Wh");
                $("#redelivery_now").html(response.data.redelivery[0] + " Wh");
                $("#intake_now").html(response.data.intake[0] + " Wh");

                if (stopUpdating) {
                    return;
                }

                var lastEnergyData = response.data
                var timestamp = lastEnergyData.timestamps[0];

                addDataToChart(energyUseLineChart, lastEnergyData.usage[0], timestamp);
                addDataToChart(energySolarLineChart, lastEnergyData.solar[0], timestamp);
                addDataToChart(energyRedeliveryLineChart, lastEnergyData.redelivery[0], timestamp);
                addDataToChart(energyIntakeLineChart, lastEnergyData.intake[0], timestamp);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function addDataToChart(lineChart, data, labels) {
    var tempData = lineChart.data.datasets[0].data;
    var tempLabels = lineChart.data.labels;

    tempData.push(data);
    tempLabels.push(labels);

    // Remove first element
    tempData.shift();
    tempLabels.shift();

    lineChart.data.datasets[0].data = tempData;
    lineChart.data.labels = tempLabels;

    lineChart.update();
}
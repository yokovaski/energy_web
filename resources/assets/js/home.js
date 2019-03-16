window.$ = window.jQuery = require('jquery');

Chart.scaleService.updateScaleDefaults('linear', {
    ticks: {
        min: 0,
        precision: 0,
        beginAtZero: true,
        suggestedMax: 1
    }
});

var defaultChartOptions = {
    legend: {
        display: false
    },
    tooltips: {
        callbacks: {
            label: function (tooltipItem) {
                return tooltipItem.yLabel;
            }
        }
    }
};

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
    getAllEnergyData('hours', 1, true);
    updateChart();

    registerClickListeners();
});

function registerClickListeners() {
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
}

function getNowChart() {
    getAllEnergyData('minutes', 10, false);
}

function getHourChart() {
    getAllEnergyData('hours', 1, false);
}

function getDayChart() {
    getAllEnergyData('hours', 24, false);
}

function getWeekChart() {
    getAllEnergyData('hours', 168, false);
}

function updateChart() {
    setInterval(function() {
        getLastEnergyData();
    }, 10000);
}

function getAllEnergyData(timeUnit, time, initChart) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/average/energy/' + timeUnit + '/' + time,
            dataType : 'JSON',
            success : function(response) {
                if(initChart){
                    initCharts(response.data);
                } else {
                    updateAllCharts(response.data);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function initCharts(energyData) {
    timeStamps = energyData.timestamps;

    energyUseLineChart = initChart("#chartEnergyUse", dataEnergyUse, energyData.usage, timeStamps);
    energySolarLineChart = initChart("#chartEnergySolar", dataEnergySolar, energyData.solar, timeStamps);
    energyRedeliveryLineChart = initChart("#chartEnergyRedelivery", dataEnergyRedelivery, energyData.redelivery, timeStamps);
    energyIntakeLineChart = initChart("#chartEnergyIntake", dataEnergyIntake, energyData.intake, timeStamps);
}

function initChart(canvasId, chartData, data, labels) {
    var canvas = document.querySelector(canvasId).getContext("2d");

    chartData.datasets[0].data = data;
    chartData.labels = labels;

    chart = new Chart(canvas, {
        type: 'line',
        data: chartData,
        options: defaultChartOptions
    });

    return chart;
}

function updateAllCharts(energyData) {
    updateChartData(energyUseLineChart, energyData.usage, energyData.timestamps);
    updateChartData(energySolarLineChart, energyData.solar, energyData.timestamps);
    updateChartData(energyRedeliveryLineChart, energyData.redelivery, energyData.timestamps);
    updateChartData(energyIntakeLineChart, energyData.intake, energyData.timestamps);
}

function updateChartData(lineChart, data, labels) {
    lineChart.data.datasets[0].data = data;
    lineChart.data.labels = labels;

    lineChart.update();
}

function getLastEnergyData() {
    $.ajax(
        {
            type : 'GET',
            url : 'api/average/energy/last',
            dataType : 'JSON',
            success : function(response) {
                $("#usage_now").html(response.data.usage[0]);
                $("#solar_now").html(response.data.solar[0]);
                $("#redelivery_now").html(response.data.redelivery[0]);
                $("#intake_now").html(response.data.intake[0]);

                if (stopUpdating) {
                    return;
                }

                getNowChart();
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
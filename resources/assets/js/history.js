window.$ = window.jQuery = require('jquery');

Chart.scaleService.updateScaleDefaults('linear', {
    ticks: {
        min: 0,
        precision: 0,
        beginAtZero: true,
        suggestedMax: 10
    }
});

var defaultChartOptions = {
    responsive: true,
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
            label: "Verbruik",
            backgroundColor: "rgba(213, 236, 246, 1.0)",
            borderColor: "rgba(169, 225, 249, 1)",
            data: null
        },{
            label: "Opwekking",
            backgroundColor: "rgba(220, 239, 217, 1.0)",
            borderColor: "rgba(177, 237, 168, 1)",
            data: null
        },{
            label: "Levering",
            backgroundColor: "rgba(255, 233, 165, 1.0)",
            borderColor: "rgba(255, 218, 107, 1)",
            data: null
        },{
            label: "Opname",
            backgroundColor: "rgba(237, 206, 206, 1.0)",
            borderColor: "rgba(247, 153, 153,1)",
            data: null
        }
    ]
};

var dataGasUse = {
    labels: null,
    datasets: [
        {
            label: "Gasverbruik",
            backgroundColor: "rgba(237, 206, 206, 1.0)",
            borderColor: "rgba(247, 153, 153,1)",
            data: null
        }
    ]
};

var energyUseBarChart;
var gasUseBarChart;

$(window).on('load', function() {
    getAllEnergyData('days', 10, true);
    getDayChart();

    $(".chartRangeSelector").click(function(){
        $(".chartRangeSelector").removeClass('active');

        if($(this).hasClass('btn-year')) {
            $('.btn-year').addClass('active');
            getYearChart();
        } else if($(this).hasClass('btn-month')) {
            $('.btn-month').addClass('active');
            getMonthChart();
        } else {
            $('.btn-day').addClass('active');
            getDayChart();
        }
    });
});

function getDayChart() {
    getAllEnergyData('days', 10, false);
}

function getMonthChart() {
    getAllEnergyData('months', 13, false);
}

function getYearChart() {
    getAllEnergyData('years', 3, false);
}

function getAllEnergyData(timeUnit, time, initChart) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/total/energy/' + timeUnit + '/' + time,
            dataType : 'JSON',
            success : function(response) {
                if(initChart) {
                    initAllCharts(response.data);
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

function initAllCharts(energyData) {
    var data = [energyData.usage, energyData.solar, energyData.redelivery, energyData.intake];
    var timestamps = energyData.timestamps;
    energyUseBarChart = initChart('#chartEnergyUse', dataEnergyUse, timestamps, data);

    data = [energyData.gas];
    gasUseBarChart = initChart('#chartGasUse', dataGasUse, timestamps, data);
}

function initChart(canvasId, dataSet, labels, data) {
    canvas = document.querySelector(canvasId).getContext("2d");

    dataSet.labels = labels;

    $.each(data, function (index, value) {
        dataSet.datasets[index].data = value;
    });

    barChart = new Chart(canvas, {
        type: 'bar',
        data: dataSet,
        options: defaultChartOptions
    });

    return barChart;
}

function updateAllCharts(energyData) {
    var data = [energyData.usage, energyData.solar, energyData.redelivery, energyData.intake];
    var timestamps = energyData.timestamps;
    writeDataToBarChart(energyUseBarChart, dataEnergyUse, timestamps, data);

    data = [energyData.gas];
    writeDataToBarChart(gasUseBarChart, dataGasUse, timestamps, data);
}

function writeDataToBarChart(barChart, dataSet, labels, data) {
    dataSet.labels = labels;

    $.each(data, function (index, value) {
        dataSet.datasets[index].data = value;
    });

    barChart.data = dataSet;
    barChart.update();
}

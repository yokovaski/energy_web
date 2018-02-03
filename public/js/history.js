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
    initAllCharts();
    getDayChart();
});

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

function getDayChart() {
    updateAllCharts('days', 10);
}

function getMonthChart() {
    updateAllCharts('months', 12);
}

function getYearChart() {
    updateAllCharts('years', 3);
}

function destroyCharts() {
    energyUseBarChart.destroy();
    gasUseBarChart.destroy();
}

function initAllCharts() {
    energyUseBarChart = initChart('#chartEnergyUse', dataEnergyUse);
    gasUseBarChart = initChart('#chartGasUse', dataGasUse);
}

function initChart(canvasId, dataSet) {
    canvas = document.querySelector(canvasId).getContext("2d");

    barChart = new Chart(canvas, {
        type: 'bar',
        data: dataSet,
        options: {
            responsive: true,
            legend: {
                position: 'top'
            }
        }
    });

    return barChart;
}

function updateAllCharts(timeUnit, time) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/total/energy/' + timeUnit + '/' + time,
            dataType : 'JSON',
            success : function(response) {
                var data = [response.data.usage, response.data.solar, response.data.redelivery, response.data.intake];
                var timestamps = response.data.timestamps;
                writeDataToBarChart(energyUseBarChart, dataEnergyUse, timestamps, data);

                var dataGas = [response.data.gas];
                writeDataToBarChart(gasUseBarChart, dataGasUse, timestamps, dataGas);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function writeDataToBarChart(barChart, dataSet, labels, data) {
    dataSet.labels = labels;

    $.each(data, function (index, value) {
        dataSet.datasets[index].data = value;
    });

    barChart.data = dataSet;
    barChart.update();
}

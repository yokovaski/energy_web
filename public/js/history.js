$(window).on('load', function() {
    getEnergyDataOfLastDays(20);
});

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
    destroyCharts();
    getEnergyDataOfLastDays(10);
}

function getMonthChart() {
    destroyCharts();
    getEnergyDataOfLastMonths(12);
}

function getYearChart() {
    destroyCharts();
    getEnergyDataOfLastYears(3);
}

function destroyCharts() {
    energyUseBarChart.destroy();
    gasUseBarChart.destroy();
}


function getEnergyDataOfLastDays(days) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/total/energy/days/' + days,
            dataType : 'JSON',
            success : function(response) {
                var data = [response.data.usage, response.data.solar, response.data.redelivery, response.data.intake];
                var canvas = document.querySelector("#chartEnergyUse").getContext("2d");
                energyUseBarChart = writeDataToBarChart(canvas, dataEnergyUse, response.data.timestamps, data);

                var dataGas = [response.data.gas];
                canvas = document.querySelector("#chartGasUse").getContext("2d");
                gasUseBarChart = writeDataToBarChart(canvas, dataGasUse, response.data.timestamps, dataGas);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function getEnergyDataOfLastMonths(months) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/total/energy/months/' + months,
            dataType : 'JSON',
            success : function(response) {
                var data = [response.data.usage, response.data.solar, response.data.redelivery, response.data.intake];
                var canvas = document.querySelector("#chartEnergyUse").getContext("2d");
                energyUseBarChart = writeDataToBarChart(canvas, dataEnergyUse, response.data.timestamps, data);

                var dataGas = [response.data.gas];
                canvas = document.querySelector("#chartGasUse").getContext("2d");
                gasUseBarChart = writeDataToBarChart(canvas, dataGasUse, response.data.timestamps, dataGas);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function getEnergyDataOfLastYears(years) {
    $.ajax(
        {
            type : 'GET',
            url : 'api/total/energy/years/' + years,
            dataType : 'JSON',
            success : function(response) {
                var data = [response.data.usage, response.data.solar, response.data.redelivery, response.data.intake];
                var canvas = document.querySelector("#chartEnergyUse").getContext("2d");
                energyUseBarChart = writeDataToBarChart(canvas, dataEnergyUse, response.data.timestamps, data);

                var dataGas = [response.data.gas];
                canvas = document.querySelector("#chartGasUse").getContext("2d");
                gasUseBarChart = writeDataToBarChart(canvas, dataGasUse, response.data.timestamps, dataGas);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function writeDataToBarChart(canvas, dataSet, labels, data) {
    dataSet.labels = labels;

    $.each(data, function (index, value) {
        dataSet.datasets[index].data = value;
    });

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

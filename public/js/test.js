$(window).on('load', function() {
    console.log("window is loaded");
    getAjaxTest();
});

google.charts.load('current', {packages: ['corechart', 'gauge']});
google.charts.setOnLoadCallback(drawLineChart);

function getAjaxTest() {
    $.ajax(
        {
            type : 'GET',
            url : 'test',
            dataType : 'JSON',
            success : function(response) {
                if(!jQuery.isEmptyObject(response)) {
                    console.log(response);
                } else {
                    $('#loading').hide();
                    $('#energy_chart_div').append("<br><p>Er zijn geen gegevens van deze maand beschikbaar</p>");

                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_current_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
}

function drawLineChart() {
    $.ajax(
        {
            // Post select to url.
            type : 'GET',
            url : "test",
            dataType : 'JSON',
            success : function(data) {
                var wrapper = new google.visualization.ChartWrapper({
                    chartType: 'LineChart',
                    dataTable: new google.visualization.DataTable(data),
                    options: {
                        'title': 'Energie (kWh)',
                        'height': 300,
                        chartArea: {width: "50%",
                            height: "70%"},
                        colors: ['#ff0000', '#00cc00']},
                    containerId: 'test'
                });
                wrapper.draw();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("ajax call to get_chart_data results into error");
                console.log(xhr.status);
                console.log(thrownError);
            }
        }
    );
}
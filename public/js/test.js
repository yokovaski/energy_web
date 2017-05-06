$(window).on('load', function() {
    console.log("window is loaded");
    // chartjsTest();
    chartjsLineChartTest();
    chartjsDoughnutTest();
});

var lineChart;

function chartjsTest() {
    console.log('some stuff');
    var ctx = document.querySelector("#chartjsTest").getContext("2d");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}

function chartjsLineChartTest() {
    var ctx = document.querySelector("#chartjsTest").getContext("2d");

    var data = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                label: "Months",
                fill: false,
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
                data: [65, 59, 80, 81, 56, 55, 40],
                spanGaps: false,
            }
        ]
    };

    lineChart = new Chart(ctx, {
        type: 'line',
        data: data
    });
}

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
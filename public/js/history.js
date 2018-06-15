/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 46);
/******/ })
/************************************************************************/
/******/ ({

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(47);


/***/ }),

/***/ 47:
/***/ (function(module, exports) {

var dataEnergyUse = {
    labels: null,
    datasets: [{
        label: "Verbruik",
        backgroundColor: "rgba(213, 236, 246, 1.0)",
        borderColor: "rgba(169, 225, 249, 1)",
        data: null
    }, {
        label: "Opwekking",
        backgroundColor: "rgba(220, 239, 217, 1.0)",
        borderColor: "rgba(177, 237, 168, 1)",
        data: null
    }, {
        label: "Levering",
        backgroundColor: "rgba(255, 233, 165, 1.0)",
        borderColor: "rgba(255, 218, 107, 1)",
        data: null
    }, {
        label: "Opname",
        backgroundColor: "rgba(237, 206, 206, 1.0)",
        borderColor: "rgba(247, 153, 153,1)",
        data: null
    }]
};

var dataGasUse = {
    labels: null,
    datasets: [{
        label: "Gasverbruik",
        backgroundColor: "rgba(237, 206, 206, 1.0)",
        borderColor: "rgba(247, 153, 153,1)",
        data: null
    }]
};

var energyUseBarChart;
var gasUseBarChart;

$(window).on('load', function () {
    getAllEnergyData('days', 10, true);
    getDayChart();
});

$(".chartRangeSelector").click(function () {
    $(".chartRangeSelector").removeClass('active');

    if ($(this).hasClass('btn-year')) {
        $('.btn-year').addClass('active');
        getYearChart();
    } else if ($(this).hasClass('btn-month')) {
        $('.btn-month').addClass('active');
        getMonthChart();
    } else {
        $('.btn-day').addClass('active');
        getDayChart();
    }
});

function getDayChart() {
    getAllEnergyData('days', 10, false);
}

function getMonthChart() {
    getAllEnergyData('months', 12, false);
}

function getYearChart() {
    getAllEnergyData('years', 3, false);
}

function getAllEnergyData(timeUnit, time, initChart) {
    $.ajax({
        type: 'GET',
        url: 'api/total/energy/' + timeUnit + '/' + time,
        dataType: 'JSON',
        success: function success(response) {
            if (initChart) {
                initAllCharts(response.data);
            } else {
                updateAllCharts(response.data);
            }
        },
        error: function error(xhr, ajaxOptions, thrownError) {
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
        options: {
            responsive: true,
            legend: {
                position: 'top'
            }
        }
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

/***/ })

/******/ });
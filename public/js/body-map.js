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
/******/ 	return __webpack_require__(__webpack_require__.s = 530);
/******/ })
/************************************************************************/
/******/ ({

/***/ 530:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(531);


/***/ }),

/***/ 531:
/***/ (function(module, exports) {

$(function () {
    // The canvas to be used
    var canvas = document.getElementById("canvas-bodymap");
    // The context for this canvas
    var context = canvas.getContext("2d");
    // The radius of the pin drawn on the canvas
    var pointSize = 4;
    // The width of the canvas and image
    var pointColor = "#ff0a11";
    // The count label next to the pin
    var pointCount = 0;

    // Draw the image onto the canvas
    drawImage();
    // When canvas is clicked get the position and draw the co-ordinates
    $("#canvas-bodymap").on("click", function (event) {
        getPosition(event);
    });
    // When save is clicked get the data URL and output value to textarea
    $("#save").on("click", function () {
        saveImage();
    });
    $("#clear").on("click", function () {
        clearCanvas();
    });

    // Draw the image onto the canvas
    function drawImage() {
        var image = document.getElementById("image-bodymap");
        context.drawImage(image, 0, 0);
    }

    // Get size and position of canvas and pass to drawCoordinates()
    function getPosition(event) {
        var rect = canvas.getBoundingClientRect();
        var x = event.clientX - rect.left;
        var y = event.clientY - rect.top;
        drawCoordinates(x, y);
    }

    // Draw the pin out where the canvas was clicked
    function drawCoordinates(x, y) {
        context.fillStyle = pointColor;
        context.beginPath();
        context.arc(x, y, pointSize, 0, Math.PI * 2, true);
        context.fill();
        drawLabel(x, y);
    }

    // Draw a counter next to the pointer which increments
    function drawLabel(x, y) {
        pointCount++;
        context.font = "bold 16px Arial";
        context.fillText(pointCount, x + 12, y);
    }

    // Clear canvas, reset the counter and redraw the image
    function clearCanvas() {
        context.clearRect(0, 0, canvas.width, canvas.height);
        pointCount = 0;
        drawImage();
    }

    // Get the Data URL for the canvas and pass to the textarea
    function saveImage() {
        var data = canvas.toDataURL();
        $("#url").val(data);
    }
});

/***/ })

/******/ });
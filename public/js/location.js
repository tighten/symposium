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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 36);
/******/ })
/************************************************************************/
/******/ ({

/***/ 36:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(37);


/***/ }),

/***/ 37:
/***/ (function(module, exports) {

var autocomplete;
var componentForm = {
    neighborhood: 'long_name', // neighborhood within borough (Williamsburg)
    sublocality_level_1: 'long_name', // borough within city (Brooklyn)
    locality: 'long_name', // city (New York, Los Angeles)
    administrative_area_level_1: 'short_name', // state (NY, CA)
    country: 'short_name' // country (US)
};

function initAutocomplete() {
    var input = document.getElementById('autocomplete');

    autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', fillPlaceData);

    // Prevent submitting account form when selecting location
    input.addEventListener("keypress", function (event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });
}

function fillPlaceData() {
    var place = autocomplete.getPlace();
    clearComponents();
    if (place.address_components) {
        place.address_components.forEach(setComponentInput);
    }
}

function clearComponents() {
    for (var component in componentForm) {
        document.getElementById(component).value = '';
    }
}

function setComponentInput(component) {
    var addressType = component.types[0];
    if (componentForm[addressType]) {
        var val = component[componentForm[addressType]];
        document.getElementById(addressType).value = val;
    }
}

/***/ })

/******/ });
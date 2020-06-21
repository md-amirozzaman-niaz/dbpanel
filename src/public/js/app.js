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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./dbpanel/src/resources/assets/js/app.js":
/*!************************************************!*\
  !*** ./dbpanel/src/resources/assets/js/app.js ***!
  \************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var json_formatter_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! json-formatter-js */ "./node_modules/json-formatter-js/dist/json-formatter.umd.js");
/* harmony import */ var json_formatter_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(json_formatter_js__WEBPACK_IMPORTED_MODULE_0__);
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }


var dataDom = document.getElementById('data');
var totalDom = document.getElementById('total');
var tableDom = document.getElementById('table');
var ulOfPagination = document.getElementsByClassName('pagination')[0];
var requestParams = document.getElementById('request-parameter');
var params = document.getElementById('parameters');
var openFileDom = document.getElementById('open-file-in-editor');

function setPagination(pageNo, total) {
  ulOfPagination.innerHTML = null;

  if (total > 1) {
    if (total > 10) {
      var st = pageNo - 4 > 1 ? pageNo - 3 : 1;
      var la = pageNo + 4 > total ? total + 1 : pageNo + 4;

      if (pageNo - 4 > 1) {
        ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" onclick="getData(' + 1 + ')">' + 1 + '</a></li>';
        ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" >...</a></li>';
      }

      for (var i = st; i < la; i++) {
        var activeClass = i == pageNo ? ' active' : '';
        ulOfPagination.innerHTML += '<li class="page-item' + activeClass + '"><a class="page-link" onclick="getData(' + i + ')">' + i + '</a></li>';
      }

      if (la < total) {
        ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" >...</a></li>';
        ulOfPagination.innerHTML += '<li class="page-item"><a class="page-link" onclick="getData(' + total + ')">' + total + '</a></li>';
      }

      ulOfPagination.innerHTML += '<li class="page-item"><div class="d-flex"><input type="number" id="pageNumber" class="form-control brr-0" value=""><div class="btn brl-0" onclick="getDataFromGoTo()">Go</div></div></li>';
    } else {
      for (var i = 1; i < total + 1; i++) {
        var _activeClass = i == pageNo ? ' active' : '';

        ulOfPagination.innerHTML += '<li class="page-item' + _activeClass + '"><a class="page-link" onclick="getData(' + i + ')">' + i + '</a></li>';
      }
    }
  }
}

window.getData = function () {
  var pageNo = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;

  if (dbpanelBeforeProcess()) {
    return;
  }

  var url = document.getElementById('uri').value + "?" + document.getElementById('query').value + "&per_page=" + document.getElementById('per_page').value + "&page=" + pageNo;
  dbpanelProcessing();
  axios.post('/dbpanel/database/' + url).then(function (response) {
    dataDom.innerHTML = null;
    var formatter = new json_formatter_js__WEBPACK_IMPORTED_MODULE_0___default.a(response.data.result.data, 1, {
      hoverPreviewEnabled: true
    });
    dataDom.appendChild(formatter.render());
    var tbleaFormatter = new json_formatter_js__WEBPACK_IMPORTED_MODULE_0___default.a(response.data.filter_status, 1, {
      hoverPreviewEnabled: true
    });
    tableDom.appendChild(tbleaFormatter.render());
    totalDom.innerHTML = 'Success';
    totalDom.classList.remove('badge-primary');
    totalDom.classList.add('badge-success');
    setPagination(response.data.result.current_page, response.data.result.last_page);
  })["catch"](function (exception) {
    if (exception["response"]) {
      dbpanelError(exception.response.data);
    } else {
      dbpanelError(exception);
    }
  });
};

window.dbpanelBeforeProcess = function () {
  if (totalDom.innerText == 'processing....') {
    console.log('one process is already runing');
    return true;
  }
};

window.dbpanelProcessing = function () {
  dataDom.innerHTML = null;
  tableDom.innerHTML = null;
  totalDom.innerHTML = 'processing....';
  totalDom.classList.remove('badge-success');
  totalDom.classList.remove('badge-danger');
  totalDom.classList.add('badge-primary');
  openFileDom.classList.contains('d-none') ? false : openFileDom.classList.add('d-none');
};

window.dbpanelProcessed = function (url) {
  axios.get(url).then(function (response) {
    if (response['data']) {
      dbpanelSuccess(response.data);
    } else {
      dbpanelSuccess(response);
    }
  })["catch"](function (exception) {
    if (exception["response"]) {
      dbpanelError(exception.response.data);
    } else {
      dbpanelError(exception);
    }
  });
};

window.loadRoute = function (event) {
  if (event.keyCode === 13) {
    var url = document.getElementById('address').value;
    var data = {
      'Url': url
    };
    changeRoute(data);
  }
};

window.changeRoute = function (data) {
  document.getElementById('webview').src = data.Url;
  document.getElementById('address').value = data.Url;
};

window.dbpanelSuccess = function (data) {
  dataDom.innerHTML = null;

  if (data["Database log"] || data["request"]) {
    var _formatter = new json_formatter_js__WEBPACK_IMPORTED_MODULE_0___default.a(data, 1, {
      hoverPreviewEnabled: true
    });

    dataDom.appendChild(_formatter.render());

    if (data['Url'] && data['Url'] !== 'no route') {
      changeRoute(data);
    }
  } else if (_typeof(data) === "object") {
    var formatter = new json_formatter_js__WEBPACK_IMPORTED_MODULE_0___default.a(data, 1, {
      hoverPreviewEnabled: true
    });
    dataDom.appendChild(formatter.render());
  } else if (data.indexOf("sf-dump") > -1) {
    dataDom.innerHTML = data;
  } else if (data.indexOf("</") > -1) {
    dataDom.innerHTML = 'custom response';
  } else {
    dataDom.innerHTML = data; // hljs.highlightBlock(dataDom);   
  }

  totalDom.innerHTML = 'Success';
  totalDom.classList.remove('badge-primary');
  totalDom.classList.add('badge-success');
};

window.dbpanelError = function (error) {
  dataDom.innerHTML = null;

  if (error == 'Error: Network Error') {
    dataDom.innerHTML = error;
  } else {
    var formatter = new json_formatter_js__WEBPACK_IMPORTED_MODULE_0___default.a(error, 1, {
      hoverPreviewEnabled: true,
      theme: 'dark'
    });
    dataDom.appendChild(formatter.render());

    if (error['file']) {
      var fileLocation = error.file;
      var line = error.line;
      var url = fileLocation + ':' + line;
      openFileDom.setAttribute('file-location', url);
      openFileDom.classList.contains('d-none') ? openFileDom.classList.remove('d-none') : false;
    }
  }

  totalDom.innerHTML = 'Error';
  totalDom.classList.remove('badge-primary');
  totalDom.classList.add('badge-danger');
};

window.openFileInEditor = function (el) {
  var param = el.getAttribute('file-location');
  axios.get('/__open-in-editor?file=' + param).then(function (response) {
    console.log('file opened');
  })["catch"](function (error) {
    console.log(error);
  });
};

window.controller = function () {
  var controller = document.getElementById('controller-input').value.replace(/\\/gi, '.');
  var dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
  var dbpanel_custom_namespace = document.getElementById("otherRequest").value;
  var rData = requestParams.value.indexOf("{") === 0 ? requestParams.value : requestParams.value.replace(/^\s+|\s+$/g, '').replace(/\n/gi, '|');
  var param = params.value;
  param = document.getElementById('hadRequest').checked ? param + '&hadRequest=' + rData + "&dbpanel_custom_namespace=" + dbpanel_custom_namespace : param;
  param = dbpanel_auth_id ? param + '&dbpanel_auth_id=' + dbpanel_auth_id : param;
  dbpanelProcessing();
  var url = '/dbpanel/controller/' + controller + '?parameters=' + param;
  dbpanelProcessed(url);
};

window.model = function () {
  var model = document.getElementById('model-input').value.replace(/\\/gi, '.');
  var dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
  var rData = requestParams.value.indexOf("{") === 0 ? requestParams.value : requestParams.value.replace(/^\s+|\s+$/g, '').replace(/\n/gi, '|');
  var param = params.value;
  param = document.getElementById('hadRequest').checked ? param + '&hadRequest=' + rData : param;
  param = dbpanel_auth_id ? param + '&dbpanel_auth_id=' + dbpanel_auth_id : param;
  dbpanelProcessing();
  var url = '/dbpanel/model/' + model + '?parameters=' + param;
  dbpanelProcessed(url);
};

window.save = function () {
  var controller = document.getElementById('controller-input').value;
  var label = document.getElementById('label').value;
  var dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
  var dbpanel_custom_namespace = document.getElementById("otherRequest").value;
  var rData = requestParams.value.indexOf("{") === 0 ? requestParams.value.replace(/  +/g, ' ') : requestParams.value.replace(/^\s+|\s+$/g, '').replace(/\n/gi, '|');
  var param = params.value;
  param += '&hadRequest=' + rData + "&dbpanel_custom_namespace=" + dbpanel_custom_namespace + "&label=" + label;
  param += '&dbpanel_auth_id=' + dbpanel_auth_id;
  var url = '/dbpanel/save?controller=' + controller + '&parameters=' + param;
  dbpanelProcessed(url);
};

window.loadToggle = function () {
  var modal = document.getElementById('loadModal');
  modal.classList.toggle('active');
};

window.activeToggle = function (el) {
  el.classList.toggle('active');
};

window.load = function (v) {
  var url = '/dbpanel/load?controller=' + v.getAttribute('data-key');
  axios.get(url).then(function (response) {
    document.getElementById('label').value = response.data['label'];
    document.getElementById('controller-input').value = response.data['controller'];
    document.getElementById('dbpanel_auth_id').value = response.data['dbpanel_auth_id'] ? response.data['dbpanel_auth_id'] : '';
    document.getElementById('hadRequest').checked = response.data['hadRequest'] ? true : false;

    if (response.data['hadRequest']) {
      requestParams.value = response.data['hadRequest'].indexOf("{") === 0 ? JSON.stringify(JSON.parse(response.data['hadRequest']), undefined, 4) : response.data['hadRequest'].replace(/\|/gi, '\n');
      ;
    } else {
      requestParams.value = '';
    }

    params.value = response.data['parameters'] ? response.data['parameters'] : '';
    document.getElementById("otherRequest").value = response.data['dbpanel_custom_namespace'] ? response.data['dbpanel_custom_namespace'] : '';
    setTimeout(function () {
      loadToggle();
      controller();
    }, 300);
  })["catch"](function (exception) {
    if (exception["response"]) {
      dbpanelError(exception.response.data);
    } else {
      dbpanelError(exception);
    }
  });
};

window.other = function () {
  var namespace = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
  var other = namespace ? document.getElementById('namespace-input').value.replace(/\\/gi, '.') : document.getElementById('other-input').value.replace(/\\/gi, '.');
  var dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
  var rData = requestParams.value.indexOf("{") === 0 ? requestParams.value : requestParams.value.replace(/\n/gi, '|');
  var param = params.value;
  param = document.getElementById('hadRequest').checked ? param + '&hadRequest=' + rData : param;
  param = dbpanel_auth_id ? param + '&dbpanel_auth_id=' + dbpanel_auth_id : param;
  dbpanelProcessing();
  var url = '/dbpanel/other/' + other + '?parameters=' + param;
  dbpanelProcessed(url);
};

window.command = function () {
  var command = document.getElementById('command-input').value;
  var dbpanel_auth_id = document.getElementById('dbpanel_auth_id').value;
  var param = dbpanel_auth_id ? '?dbpanel_auth_id=' + dbpanel_auth_id : '';
  dbpanelProcessing();
  var url = '/dbpanel/command/' + command + param;
  dbpanelProcessed(url);
};

window.checkMethod = function () {
  if (dbpanelBeforeProcess()) {
    return;
  }

  ulOfPagination.innerHTML = null;
  var whichMethod = document.getElementById('mySideBarTab').getElementsByClassName('active')[0].innerText.trim().toLowerCase();

  if (whichMethod == 'controller') {
    window.controller();
  } else if (whichMethod == 'model') {
    window.model();
  } else if (whichMethod == 'command') {
    window.command();
  } else if (whichMethod == 'namespace') {
    window.other('namespace');
  } else {
    window.other();
  }
};

window.getDataFromGoTo = function () {
  var p = document.getElementById('pageNumber').value;
  window.getData(p);
};

window.viewInfo = function () {
  event.stopPropagation();
  document.getElementsByClassName('info-container')[0].classList.toggle('active');
};

document.addEventListener('DOMContentLoaded', function (event) {
  document.querySelectorAll('pre code').forEach(function (block) {
    hljs.highlightBlock(block);
  });
});
document.addEventListener('DOMContentLoaded', function (event) {
  document.querySelectorAll('td code').forEach(function (block) {
    hljs.highlightBlock(block);
  });
});

/***/ }),

/***/ "./node_modules/json-formatter-js/dist/json-formatter.umd.js":
/*!*******************************************************************!*\
  !*** ./node_modules/json-formatter-js/dist/json-formatter.umd.js ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

!function(t,e){ true?module.exports=e():undefined}(this,(function(){"use strict";function t(t){return null===t?"null":typeof t}function e(t){return!!t&&"object"==typeof t}function r(t){if(void 0===t)return"";if(null===t)return"Object";if("object"==typeof t&&!t.constructor)return"Object";var e=/function ([^(]*)/.exec(t.constructor.toString());return e&&e.length>1?e[1]:""}function n(t,e,r){return"null"===t||"undefined"===t?t:("string"!==t&&"stringifiable"!==t||(r='"'+r.replace(/"/g,'\\"')+'"'),"function"===t?e.toString().replace(/[\r\n]/g,"").replace(/\{.*\}/,"")+"{…}":r)}function o(o){var i="";return e(o)?(i=r(o),Array.isArray(o)&&(i+="["+o.length+"]")):i=n(t(o),o,o),i}function i(t){return"json-formatter-"+t}function s(t,e,r){var n=document.createElement(t);return e&&n.classList.add(i(e)),void 0!==r&&(r instanceof Node?n.appendChild(r):n.appendChild(document.createTextNode(String(r)))),n}!function(t){if(t&&"undefined"!=typeof window){var e=document.createElement("style");e.setAttribute("media","screen"),e.innerHTML=t,document.head.appendChild(e)}}('.json-formatter-row {\n  font-family: monospace;\n}\n.json-formatter-row,\n.json-formatter-row a,\n.json-formatter-row a:hover {\n  color: black;\n  text-decoration: none;\n}\n.json-formatter-row .json-formatter-row {\n  margin-left: 1rem;\n}\n.json-formatter-row .json-formatter-children.json-formatter-empty {\n  opacity: 0.5;\n  margin-left: 1rem;\n}\n.json-formatter-row .json-formatter-children.json-formatter-empty:after {\n  display: none;\n}\n.json-formatter-row .json-formatter-children.json-formatter-empty.json-formatter-object:after {\n  content: "No properties";\n}\n.json-formatter-row .json-formatter-children.json-formatter-empty.json-formatter-array:after {\n  content: "[]";\n}\n.json-formatter-row .json-formatter-string,\n.json-formatter-row .json-formatter-stringifiable {\n  color: green;\n  white-space: pre;\n  word-wrap: break-word;\n}\n.json-formatter-row .json-formatter-number {\n  color: blue;\n}\n.json-formatter-row .json-formatter-boolean {\n  color: red;\n}\n.json-formatter-row .json-formatter-null {\n  color: #855A00;\n}\n.json-formatter-row .json-formatter-undefined {\n  color: #ca0b69;\n}\n.json-formatter-row .json-formatter-function {\n  color: #FF20ED;\n}\n.json-formatter-row .json-formatter-date {\n  background-color: rgba(0, 0, 0, 0.05);\n}\n.json-formatter-row .json-formatter-url {\n  text-decoration: underline;\n  color: blue;\n  cursor: pointer;\n}\n.json-formatter-row .json-formatter-bracket {\n  color: blue;\n}\n.json-formatter-row .json-formatter-key {\n  color: #00008B;\n  padding-right: 0.2rem;\n}\n.json-formatter-row .json-formatter-toggler-link {\n  cursor: pointer;\n}\n.json-formatter-row .json-formatter-toggler {\n  line-height: 1.2rem;\n  font-size: 0.7rem;\n  vertical-align: middle;\n  opacity: 0.6;\n  cursor: pointer;\n  padding-right: 0.2rem;\n}\n.json-formatter-row .json-formatter-toggler:after {\n  display: inline-block;\n  transition: transform 100ms ease-in;\n  content: "►";\n}\n.json-formatter-row > a > .json-formatter-preview-text {\n  opacity: 0;\n  transition: opacity 0.15s ease-in;\n  font-style: italic;\n}\n.json-formatter-row:hover > a > .json-formatter-preview-text {\n  opacity: 0.6;\n}\n.json-formatter-row.json-formatter-open > .json-formatter-toggler-link .json-formatter-toggler:after {\n  transform: rotate(90deg);\n}\n.json-formatter-row.json-formatter-open > .json-formatter-children:after {\n  display: inline-block;\n}\n.json-formatter-row.json-formatter-open > a > .json-formatter-preview-text {\n  display: none;\n}\n.json-formatter-row.json-formatter-open.json-formatter-empty:after {\n  display: block;\n}\n.json-formatter-dark.json-formatter-row {\n  font-family: monospace;\n}\n.json-formatter-dark.json-formatter-row,\n.json-formatter-dark.json-formatter-row a,\n.json-formatter-dark.json-formatter-row a:hover {\n  color: white;\n  text-decoration: none;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-row {\n  margin-left: 1rem;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-children.json-formatter-empty {\n  opacity: 0.5;\n  margin-left: 1rem;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-children.json-formatter-empty:after {\n  display: none;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-children.json-formatter-empty.json-formatter-object:after {\n  content: "No properties";\n}\n.json-formatter-dark.json-formatter-row .json-formatter-children.json-formatter-empty.json-formatter-array:after {\n  content: "[]";\n}\n.json-formatter-dark.json-formatter-row .json-formatter-string,\n.json-formatter-dark.json-formatter-row .json-formatter-stringifiable {\n  color: #31F031;\n  white-space: pre;\n  word-wrap: break-word;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-number {\n  color: #66C2FF;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-boolean {\n  color: #EC4242;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-null {\n  color: #EEC97D;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-undefined {\n  color: #ef8fbe;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-function {\n  color: #FD48CB;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-date {\n  background-color: rgba(255, 255, 255, 0.05);\n}\n.json-formatter-dark.json-formatter-row .json-formatter-url {\n  text-decoration: underline;\n  color: #027BFF;\n  cursor: pointer;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-bracket {\n  color: #9494FF;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-key {\n  color: #23A0DB;\n  padding-right: 0.2rem;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-toggler-link {\n  cursor: pointer;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-toggler {\n  line-height: 1.2rem;\n  font-size: 0.7rem;\n  vertical-align: middle;\n  opacity: 0.6;\n  cursor: pointer;\n  padding-right: 0.2rem;\n}\n.json-formatter-dark.json-formatter-row .json-formatter-toggler:after {\n  display: inline-block;\n  transition: transform 100ms ease-in;\n  content: "►";\n}\n.json-formatter-dark.json-formatter-row > a > .json-formatter-preview-text {\n  opacity: 0;\n  transition: opacity 0.15s ease-in;\n  font-style: italic;\n}\n.json-formatter-dark.json-formatter-row:hover > a > .json-formatter-preview-text {\n  opacity: 0.6;\n}\n.json-formatter-dark.json-formatter-row.json-formatter-open > .json-formatter-toggler-link .json-formatter-toggler:after {\n  transform: rotate(90deg);\n}\n.json-formatter-dark.json-formatter-row.json-formatter-open > .json-formatter-children:after {\n  display: inline-block;\n}\n.json-formatter-dark.json-formatter-row.json-formatter-open > a > .json-formatter-preview-text {\n  display: none;\n}\n.json-formatter-dark.json-formatter-row.json-formatter-open.json-formatter-empty:after {\n  display: block;\n}\n');var a=/(^\d{1,4}[\.|\\/|-]\d{1,2}[\.|\\/|-]\d{1,4})(\s*(?:0?[1-9]:[0-5]|1(?=[012])\d:[0-5])\d\s*[ap]m)?$/,f=/\d{2}:\d{2}:\d{2} GMT-\d{4}/,m=/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z/,l=window.requestAnimationFrame||function(t){return t(),0},d={hoverPreviewEnabled:!1,hoverPreviewArrayCount:100,hoverPreviewFieldCount:5,animateOpen:!0,animateClose:!0,theme:null,useToJSON:!0,sortPropertiesBy:null};return function(){function c(t,e,r,n){void 0===e&&(e=1),void 0===r&&(r=d),this.json=t,this.open=e,this.config=r,this.key=n,this._isOpen=null,void 0===this.config.hoverPreviewEnabled&&(this.config.hoverPreviewEnabled=d.hoverPreviewEnabled),void 0===this.config.hoverPreviewArrayCount&&(this.config.hoverPreviewArrayCount=d.hoverPreviewArrayCount),void 0===this.config.hoverPreviewFieldCount&&(this.config.hoverPreviewFieldCount=d.hoverPreviewFieldCount),void 0===this.config.useToJSON&&(this.config.useToJSON=d.useToJSON),""===this.key&&(this.key='""')}return Object.defineProperty(c.prototype,"isOpen",{get:function(){return null!==this._isOpen?this._isOpen:this.open>0},set:function(t){this._isOpen=t},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"isDate",{get:function(){return this.json instanceof Date||"string"===this.type&&(a.test(this.json)||m.test(this.json)||f.test(this.json))},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"isUrl",{get:function(){return"string"===this.type&&0===this.json.indexOf("http")},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"isArray",{get:function(){return Array.isArray(this.json)},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"isObject",{get:function(){return e(this.json)},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"isEmptyObject",{get:function(){return!this.keys.length&&!this.isArray},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"isEmpty",{get:function(){return this.isEmptyObject||this.keys&&!this.keys.length&&this.isArray},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"useToJSON",{get:function(){return this.config.useToJSON&&"stringifiable"===this.type},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"hasKey",{get:function(){return void 0!==this.key},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"constructorName",{get:function(){return r(this.json)},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"type",{get:function(){return this.config.useToJSON&&this.json&&this.json.toJSON?"stringifiable":t(this.json)},enumerable:!0,configurable:!0}),Object.defineProperty(c.prototype,"keys",{get:function(){if(this.isObject){var t=Object.keys(this.json);return!this.isArray&&this.config.sortPropertiesBy?t.sort(this.config.sortPropertiesBy):t}return[]},enumerable:!0,configurable:!0}),c.prototype.toggleOpen=function(){this.isOpen=!this.isOpen,this.element&&(this.isOpen?this.appendChildren(this.config.animateOpen):this.removeChildren(this.config.animateClose),this.element.classList.toggle(i("open")))},c.prototype.openAtDepth=function(t){void 0===t&&(t=1),t<0||(this.open=t,this.isOpen=0!==t,this.element&&(this.removeChildren(!1),0===t?this.element.classList.remove(i("open")):(this.appendChildren(this.config.animateOpen),this.element.classList.add(i("open")))))},c.prototype.getInlinepreview=function(){var t=this;if(this.isArray)return this.json.length>this.config.hoverPreviewArrayCount?"Array["+this.json.length+"]":"["+this.json.map(o).join(", ")+"]";var e=this.keys,r=e.slice(0,this.config.hoverPreviewFieldCount).map((function(e){return e+":"+o(t.json[e])})),n=e.length>=this.config.hoverPreviewFieldCount?"…":"";return"{"+r.join(", ")+n+"}"},c.prototype.render=function(){this.element=s("div","row");var t=this.isObject?s("a","toggler-link"):s("span");if(this.isObject&&!this.useToJSON&&t.appendChild(s("span","toggler")),this.hasKey&&t.appendChild(s("span","key",this.key+":")),this.isObject&&!this.useToJSON){var e=s("span","value"),r=s("span"),o=s("span","constructor-name",this.constructorName);if(r.appendChild(o),this.isArray){var a=s("span");a.appendChild(s("span","bracket","[")),a.appendChild(s("span","number",this.json.length)),a.appendChild(s("span","bracket","]")),r.appendChild(a)}e.appendChild(r),t.appendChild(e)}else{(e=this.isUrl?s("a"):s("span")).classList.add(i(this.type)),this.isDate&&e.classList.add(i("date")),this.isUrl&&(e.classList.add(i("url")),e.setAttribute("href",this.json));var f=n(this.type,this.json,this.useToJSON?this.json.toJSON():this.json);e.appendChild(document.createTextNode(f)),t.appendChild(e)}if(this.isObject&&this.config.hoverPreviewEnabled){var m=s("span","preview-text");m.appendChild(document.createTextNode(this.getInlinepreview())),t.appendChild(m)}var l=s("div","children");return this.isObject&&l.classList.add(i("object")),this.isArray&&l.classList.add(i("array")),this.isEmpty&&l.classList.add(i("empty")),this.config&&this.config.theme&&this.element.classList.add(i(this.config.theme)),this.isOpen&&this.element.classList.add(i("open")),this.element.appendChild(t),this.element.appendChild(l),this.isObject&&this.isOpen&&this.appendChildren(),this.isObject&&!this.useToJSON&&t.addEventListener("click",this.toggleOpen.bind(this)),this.element},c.prototype.appendChildren=function(t){var e=this;void 0===t&&(t=!1);var r=this.element.querySelector("div."+i("children"));if(r&&!this.isEmpty)if(t){var n=0,o=function(){var t=e.keys[n],i=new c(e.json[t],e.open-1,e.config,t);r.appendChild(i.render()),(n+=1)<e.keys.length&&(n>10?o():l(o))};l(o)}else this.keys.forEach((function(t){var n=new c(e.json[t],e.open-1,e.config,t);r.appendChild(n.render())}))},c.prototype.removeChildren=function(t){void 0===t&&(t=!1);var e=this.element.querySelector("div."+i("children"));if(t){var r=0,n=function(){e&&e.children.length&&(e.removeChild(e.children[0]),(r+=1)>10?n():l(n))};l(n)}else e&&(e.innerHTML="")},c}()}));


/***/ }),

/***/ 0:
/*!******************************************************!*\
  !*** multi ./dbpanel/src/resources/assets/js/app.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\wamp64\www\laravelHome\pipeline\package\dbpanel\src\resources\assets\js\app.js */"./dbpanel/src/resources/assets/js/app.js");


/***/ })

/******/ });
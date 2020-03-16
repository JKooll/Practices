require("../../common/manifest.js")
require("../../common/vendor.js")
global.webpackJsonpMpvue([2],[
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__index__ = __webpack_require__(9);



// add this to handle exception
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.config.errorHandler = function (err) {
  if (console && console.error) {
    console.error(err);
  }
};

var app = new __WEBPACK_IMPORTED_MODULE_0_vue___default.a(__WEBPACK_IMPORTED_MODULE_1__index__["a" /* default */]);
app.$mount();

/***/ }),
/* 9 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_mpvue_loader_lib_selector_type_script_index_0_index_vue__ = __webpack_require__(11);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_mpvue_loader_lib_template_compiler_index_id_data_v_6745d98c_hasScoped_false_transformToRequire_video_src_source_src_img_src_image_xlink_href_fileExt_template_wxml_script_js_style_wxss_platform_wx_node_modules_mpvue_loader_lib_selector_type_template_index_0_index_vue__ = __webpack_require__(12);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(10)
}
var normalizeComponent = __webpack_require__(1)
/* script */

/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_mpvue_loader_lib_selector_type_script_index_0_index_vue__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_1__node_modules_mpvue_loader_lib_template_compiler_index_id_data_v_6745d98c_hasScoped_false_transformToRequire_video_src_source_src_img_src_image_xlink_href_fileExt_template_wxml_script_js_style_wxss_platform_wx_node_modules_mpvue_loader_lib_selector_type_template_index_0_index_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "src/pages/calculator/index.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] index.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6745d98c", Component.options)
  } else {
    hotAPI.reload("data-v-6745d98c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 10 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 11 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

var CalculatorOperations = {
  '/': function _(prevValue, nextValue) {
    return prevValue / nextValue;
  },
  '*': function _(prevValue, nextValue) {
    return prevValue * nextValue;
  },
  '+': function _(prevValue, nextValue) {
    return prevValue + nextValue;
  },
  '-': function _(prevValue, nextValue) {
    return prevValue - nextValue;
  },
  '=': function _(prevValue, nextValue) {
    return nextValue;
  }
};
/* harmony default export */ __webpack_exports__["a"] = ({
  data: function data() {
    return {
      value: null,
      displayValue: '0',
      operator: null,
      waitingForOperand: false,
      eventChannel: null
    };
  },

  methods: {
    clearAll: function clearAll() {
      this.value = null;
      this.displayValue = '0';
      this.operator = null;
      this.waitingForOperand = false;
    },
    clearDisplay: function clearDisplay() {
      this.displayValue = '0';
    },
    clearLastChar: function clearLastChar() {
      this.displayValue = this.displayValue.substring(0, this.displayValue.length - 1) || '0';
    },
    clear: function clear() {
      if (this.displayValue !== '0') {
        this.clearDisplay();
      } else {
        this.clearAll();
      }
    },
    toggleSign: function toggleSign() {
      var newValue = parseFloat(this.displayValue) * -1;
      this.displayValue = String(newValue);
    },
    inputPercent: function inputPercent() {
      var currentValue = parseFloat(this.displayValue);
      if (currentValue === 0) {
        return;
      }
      var fixedDigits = this.displayValue.replace(/^-?\d*\./, '');
      var newValue = parseFloat(this.displayValue) / 100;
      this.displayValue = String(newValue.toFixed(fixedDigits.length + 2));
    },
    inputDot: function inputDot() {
      if (!/\./.test(this.displayValue)) {
        this.displayValue += '.';
        this.waitingForOperand = false;
      }
    },
    performOperation: function performOperation(nextOperator) {
      var inputValue = parseFloat(this.displayValue);
      if (this.value == null) {
        this.value = inputValue;
      } else if (this.operator) {
        var currentValue = this.value || 0;
        var newValue = CalculatorOperations[this.operator](currentValue, inputValue);
        this.value = newValue;
        this.displayValue = String(newValue);
      }

      this.waitingForOperand = true;
      this.operator = nextOperator;
    },
    inputDigit: function inputDigit(digit) {
      if (this.waitingForOperand) {
        this.displayValue = String(digit);
        this.waitingForOperand = false;
      } else {
        this.displayValue = this.displayValue === '0' ? String(digit) : this.displayValue + digit;
      }
    }
  },
  computed: {
    clearText: function clearText() {
      return this.displayValue !== '0' ? 'C' : 'AC';
    }
  },
  watch: {
    displayValue: function displayValue(val) {
      if (val !== null && this.eventChannel) {
        this.eventChannel.emit('acceptDataFromOpenedPage', parseFloat(val));
      }
    }
  },
  onLoad: function onLoad(option) {
    this.eventChannel = this.$mp.page.getOpenerEventChannel();
  }
});

/***/ }),
/* 12 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "wrapper"
    }
  }, [_c('div', {
    attrs: {
      "id": "app"
    }
  }, [_c('div', {
    staticClass: "calculator"
  }, [_c('div', {
    staticClass: "calculator-display"
  }, [_c('div', {
    staticClass: "auto-scaling-text"
  }, [_vm._v("\n          " + _vm._s(_vm.displayValue) + "\n        ")])]), _vm._v(" "), _c('div', {
    staticClass: "calculator-keypad"
  }, [_c('div', {
    staticClass: "calculator-row"
  }, [_c('button', {
    staticClass: "calculator-key function-key",
    attrs: {
      "eventid": '0'
    },
    on: {
      "click": function($event) {
        _vm.clear()
      }
    }
  }, [_vm._v(_vm._s(_vm.clearText))]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key function-key",
    attrs: {
      "eventid": '1'
    },
    on: {
      "click": function($event) {
        _vm.toggleSign()
      }
    }
  }, [_vm._v("±")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key function-key",
    attrs: {
      "eventid": '2'
    },
    on: {
      "click": function($event) {
        _vm.inputPercent()
      }
    }
  }, [_vm._v("%")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key operator-key",
    attrs: {
      "eventid": '3'
    },
    on: {
      "click": function($event) {
        _vm.performOperation('/')
      }
    }
  }, [_vm._v("÷")])], 1), _vm._v(" "), _c('div', {
    staticClass: "calculator-row"
  }, [_c('button', {
    staticClass: "calculator-key digit-key key-7",
    attrs: {
      "eventid": '4'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(7)
      }
    }
  }, [_vm._v("7")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key digit-key key-8",
    attrs: {
      "eventid": '5'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(8)
      }
    }
  }, [_vm._v("8")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key digit-key key-9",
    attrs: {
      "eventid": '6'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(9)
      }
    }
  }, [_vm._v("9")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key operator-key",
    attrs: {
      "eventid": '7'
    },
    on: {
      "click": function($event) {
        _vm.performOperation('*')
      }
    }
  }, [_vm._v("×")])], 1), _vm._v(" "), _c('div', {
    staticClass: "calculator-row"
  }, [_c('button', {
    staticClass: "calculator-key digit-key key-4",
    attrs: {
      "eventid": '8'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(4)
      }
    }
  }, [_vm._v("4")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key digit-key key-5",
    attrs: {
      "eventid": '9'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(5)
      }
    }
  }, [_vm._v("5")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key digit-key key-6",
    attrs: {
      "eventid": '10'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(6)
      }
    }
  }, [_vm._v("6")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key operator-key",
    attrs: {
      "eventid": '11'
    },
    on: {
      "click": function($event) {
        _vm.performOperation('-')
      }
    }
  }, [_vm._v("−")])], 1), _vm._v(" "), _c('div', {
    staticClass: "calculator-row"
  }, [_c('button', {
    staticClass: "calculator-key digit-key key-1",
    attrs: {
      "eventid": '12'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(1)
      }
    }
  }, [_vm._v("1")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key digit-key key-2",
    attrs: {
      "eventid": '13'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(2)
      }
    }
  }, [_vm._v("2")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key digit-key key-3",
    attrs: {
      "eventid": '14'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(3)
      }
    }
  }, [_vm._v("3")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key operator-key",
    attrs: {
      "eventid": '15'
    },
    on: {
      "click": function($event) {
        _vm.performOperation('+')
      }
    }
  }, [_vm._v("+")])], 1), _vm._v(" "), _c('div', {
    staticClass: "calculator-row"
  }, [_c('button', {
    staticClass: "calculator-key digit-key key-0",
    attrs: {
      "eventid": '16'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(0)
      }
    }
  }, [_vm._v("0")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key digit-key key-dot",
    attrs: {
      "eventid": '17'
    },
    on: {
      "click": function($event) {
        _vm.inputDot()
      }
    }
  }, [_vm._v("●")]), _vm._v(" "), _c('button', {
    staticClass: "calculator-key operator-key",
    attrs: {
      "eventid": '18'
    },
    on: {
      "click": function($event) {
        _vm.performOperation('=')
      }
    }
  }, [_vm._v("=")])], 1)])])])])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-6745d98c", esExports)
  }
}

/***/ })
],[8]);
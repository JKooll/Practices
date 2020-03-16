require("../../common/manifest.js")
require("../../common/vendor.js")
global.webpackJsonpMpvue([1],[
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__index__ = __webpack_require__(14);



// add this to handle exception
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.config.errorHandler = function (err) {
  if (console && console.error) {
    console.error(err);
  }
};

var app = new __WEBPACK_IMPORTED_MODULE_0_vue___default.a(__WEBPACK_IMPORTED_MODULE_1__index__["a" /* default */]);
app.$mount();

/***/ }),
/* 14 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_mpvue_loader_lib_selector_type_script_index_0_index_vue__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_mpvue_loader_lib_template_compiler_index_id_data_v_88d3f0a0_hasScoped_false_transformToRequire_video_src_source_src_img_src_image_xlink_href_fileExt_template_wxml_script_js_style_wxss_platform_wx_node_modules_mpvue_loader_lib_selector_type_template_index_0_index_vue__ = __webpack_require__(17);
var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(15)
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
  __WEBPACK_IMPORTED_MODULE_1__node_modules_mpvue_loader_lib_template_compiler_index_id_data_v_88d3f0a0_hasScoped_false_transformToRequire_video_src_source_src_img_src_image_xlink_href_fileExt_template_wxml_script_js_style_wxss_platform_wx_node_modules_mpvue_loader_lib_selector_type_template_index_0_index_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "src/pages/index/index.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] index.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-88d3f0a0", Component.options)
  } else {
    hotAPI.reload("data-v-88d3f0a0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

/* harmony default export */ __webpack_exports__["a"] = (Component.exports);


/***/ }),
/* 15 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 16 */
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

/* harmony default export */ __webpack_exports__["a"] = ({
  data: function data() {
    return {
      countryOrAreas: null,
      selectedCountryOrAreas: null,
      allow_currency_alpha2Code: ['CN', 'US', 'JP', 'HK', 'GB', 'CA', 'AU', 'TW', 'MO', 'KR', 'RU', 'MY', 'SE'],
      exchange_rates: null,
      baseCurrency: 'CN'
    };
  },

  methods: {
    // 请求国家或地区列表
    requestCountryOrAreas: function requestCountryOrAreas(successCallback) {
      wx.request({
        url: 'https://restcountries.eu/rest/v2/all?fields=alpha2Code;flag;currencies',
        success: function success(res) {
          for (var i in res.data) {
            if (!res.data[i].value) {
              res.data[i]['displayValue'] = '0';
            }
          }
          successCallback(res);
        }
      });
    },
    openCalculator: function openCalculator() {
      var that = this;
      wx.navigateTo({
        url: '/pages/calculator/main',
        events: {
          acceptDataFromOpenedPage: function acceptDataFromOpenedPage(data) {
            var baseCountryOrArea = that.getBaseCurrencyCountryOrArea();
            that.setCountryOrAreaValue(baseCountryOrArea, data);
          }
        }
      });
    },
    inputDigit: function inputDigit(digit) {
      var baseCurrencyCountryOrArea = this.getBaseCurrencyCountryOrArea();
      baseCurrencyCountryOrArea.displayValue = baseCurrencyCountryOrArea.displayValue === '0' ? String(digit) : baseCurrencyCountryOrArea.displayValue + String(digit);
      this.refreshCurrency();
    },
    inputDot: function inputDot() {
      var baseCurrencyCountryOrArea = this.getBaseCurrencyCountryOrArea();
      if (!/\./.test(baseCurrencyCountryOrArea.displayValue)) {
        baseCurrencyCountryOrArea.displayValue += '.';
      }
      this.refreshCurrency();
    },
    clear: function clear() {
      var baseCurrencyCountryOrArea = this.getBaseCurrencyCountryOrArea();
      baseCurrencyCountryOrArea.displayValue = '0';
      baseCurrencyCountryOrArea.value = 0;
      this.refreshCurrency();
    },
    refreshExchangeRate: function refreshExchangeRate() {
      this.requestExchangeRates();
    },
    getBaseCurrencyCountryOrArea: function getBaseCurrencyCountryOrArea() {
      for (var index in this.selectedCountryOrAreas) {
        if (this.selectedCountryOrAreas[index].alpha2Code === this.baseCurrency) {
          return this.selectedCountryOrAreas[index];
        }
      }
      return null;
    },
    refreshCurrency: function refreshCurrency() {
      if (!this.exchange_rates) {
        return;
      }
      var baseCountryOrArea = this.getBaseCurrencyCountryOrArea();
      for (var index in this.selectedCountryOrAreas) {
        var targetCountryOrArea = this.selectedCountryOrAreas[index];
        if (targetCountryOrArea.alpha2Code === this.baseCurrency) {
          continue;
        }
        var baseCurrencyCode = baseCountryOrArea.currencies[0].code;
        var baseCurrencyValue = this.getCountryOrAreaValue(baseCountryOrArea);
        var targetCurrencyCode = targetCountryOrArea.currencies[0].code;
        var targetValue = baseCurrencyValue / this.exchange_rates[baseCurrencyCode] * this.exchange_rates[targetCurrencyCode];
        this.setCountryOrAreaValue(targetCountryOrArea, targetValue);
      }
    },
    getCountryOrAreaValue: function getCountryOrAreaValue(countryOrArea) {
      return parseFloat(countryOrArea.displayValue);
    },
    setCountryOrAreaValue: function setCountryOrAreaValue(countryOrArea, value) {
      if (value === 0) {
        countryOrArea.displayValue = String(0);
      } else {
        countryOrArea.displayValue = String(value.toFixed(2));
      }
    },
    requestExchangeRates: function requestExchangeRates() {
      var that = this;
      wx.request({
        url: 'http://data.fixer.io/api/latest',
        data: {
          access_key: '82826d4a20e318d3168e40eb27817912',
          format: 1
        },
        success: function success(res) {
          that.exchange_rates = res.data.rates;
          wx.setStorage({
            key: 'exchange_rates',
            data: {
              rates: res.data.rates,
              timestamp: +new Date()
            }
          });
        }
      });
    }
  },
  onLoad: function onLoad() {
    // get all country or areas list list
    var that = this;
    wx.getStorage({
      key: 'countryOrAreas',
      success: function success(res) {
        that.countryOrAreas = res.data;
      },
      fail: function fail() {
        that.requestCountryOrAreas(function (res) {
          that.countryOrAreas = [];
          for (var index in res.data) {
            var currentCurrencyCode = res.data[index].alpha2Code;
            if (that.allow_currency_alpha2Code.includes(currentCurrencyCode)) {
              that.countryOrAreas.push(res.data[index]);
              console.log(res.data[index].displayValue);
            }
          }
          wx.setStorage({
            key: 'countryOrAreas',
            data: that.countryOrAreas
          });
        });
      }
    });

    // get selected list
    wx.getStorage({
      key: 'selectedCountryOrAreas',
      success: function success(res) {
        that.selectedCountryOrAreas = res.data;
      },
      fail: function fail(res) {
        wx.request({
          url: 'https://restcountries.eu/rest/v2/all?fields=alpha2Code;flag;currencies',
          success: function success(res) {
            that.requestCountryOrAreas(function (res) {
              that.selectedCountryOrAreas = [];
              for (var i = 0; i < 5; i++) {
                for (var index in res.data) {
                  var currentCurrencyCode = res.data[index].alpha2Code;
                  if (that.allow_currency_alpha2Code[i] === currentCurrencyCode) {
                    that.selectedCountryOrAreas.push(res.data[index]);
                  }
                }
              }
              wx.setStorage({
                key: 'selectedCountryOrAreas',
                data: that.selectedCountryOrAreas
              });
            });
          }
        });
      }
    });

    // get base currency contryorarea alpha2Coe
    wx.getStorage({
      key: 'baseCurrency',
      success: function success(res) {
        that.baseCurrency = res.data;
      },
      fail: function fail() {
        that.baseCurrency = that.allow_currency_alpha2Code[0];
        wx.setStorage({
          key: 'baseCurrency',
          data: that.baseCurrency
        });
      }
    });

    // get currency value
    wx.getStorage({
      key: 'currencyValue',
      success: function success(res) {
        that.currentCurrencyCode = res.data;
      },
      fail: function fail() {
        that.currencyValue = 0;
        wx.setStorage({
          key: 'currencyValue',
          data: that.currentCurrencyCode
        });
      }
    });

    // 获取汇率列表
    wx.getStorage({
      key: 'exchange_rates',
      success: function success(res) {
        var timestamp = res.data.timestamp;
        var currentTimestamp = +new Date();
        if (Math.abs(currentTimestamp - timestamp) > 30 * 60 * 1000) {
          that.requestExchangeRates();
        }
      },
      fail: function fail() {
        that.requestExchangeRates();
      }
    });
  }
});

/***/ }),
/* 17 */
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
    staticClass: "currency-list"
  }, _vm._l((_vm.selectedCountryOrAreas), function(item, index) {
    return _c('div', {
      key: index,
      staticClass: "currency-list-item",
      attrs: {
        "eventid": '0_' + index
      },
      on: {
        "click": function($event) {
          _vm.baseCurrency = item.alpha2Code
        }
      }
    }, [_c('div', {
      staticClass: "currency-list-item-col"
    }, [_c('image', {
      staticStyle: {
        "width": "32px"
      },
      attrs: {
        "src": item.flag,
        "mode": "widthFix"
      }
    })]), _vm._v(" "), _c('div', {
      staticClass: "currency-list-item-col"
    }, [_vm._v(_vm._s(item.currencies[0].code) + " " + _vm._s(item.currencies[0].symbol))]), _vm._v(" "), _c('div', {
      staticClass: "currency-list-item-col"
    }, [_vm._v(_vm._s(item.displayValue))]), _vm._v(" "), _c('div', {
      staticClass: "currency-list-item-col"
    }, [_c('radio', {
      staticClass: "radio",
      attrs: {
        "checked": _vm.baseCurrency === item.alpha2Code
      }
    })], 1)])
  })), _vm._v(" "), _c('div', {
    staticClass: "key-pad"
  }, [_c('button', {
    staticClass: "key key-clear operation-key",
    attrs: {
      "eventid": '1'
    },
    on: {
      "click": function($event) {
        _vm.clear()
      }
    }
  }, [_vm._v("C")]), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '2'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(7)
      }
    }
  }, [_vm._v("7")]), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '3'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(8)
      }
    }
  }, [_vm._v("8")]), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '4'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(9)
      }
    }
  }, [_vm._v("9")]), _vm._v(" "), _c('button', {
    staticClass: "key operation-key",
    attrs: {
      "eventid": '5'
    },
    on: {
      "click": function($event) {
        _vm.refreshExchangeRate()
      }
    }
  }, [_c('i-icon', {
    attrs: {
      "type": "refresh",
      "clor": "#FFFFFF",
      "size": "53",
      "mpcomid": '0'
    }
  })], 1), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '6'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(4)
      }
    }
  }, [_vm._v("4")]), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '7'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(5)
      }
    }
  }, [_vm._v("5")]), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '8'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(6)
      }
    }
  }, [_vm._v("6")]), _vm._v(" "), _c('button', {
    staticClass: "key operation-key key-calculator",
    attrs: {
      "eventid": '9'
    },
    on: {
      "click": function($event) {
        _vm.openCalculator()
      }
    }
  }, [_c('image', {
    staticStyle: {
      "width": "53px"
    },
    attrs: {
      "mode": "widthFix",
      "src": "../../static/images/calculator.png"
    }
  })]), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '10'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(1)
      }
    }
  }, [_vm._v("1")]), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '11'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(2)
      }
    }
  }, [_vm._v("2")]), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '12'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(3)
      }
    }
  }, [_vm._v("3")]), _vm._v(" "), _c('button', {
    staticClass: "key key-0 digit-key",
    attrs: {
      "eventid": '13'
    },
    on: {
      "click": function($event) {
        _vm.inputDigit(0)
      }
    }
  }, [_vm._v("0")]), _vm._v(" "), _c('button', {
    staticClass: "key digit-key",
    attrs: {
      "eventid": '14'
    },
    on: {
      "click": function($event) {
        _vm.inputDot()
      }
    }
  }, [_vm._v("●")])], 1)])])
}
var staticRenderFns = []
render._withStripped = true
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-88d3f0a0", esExports)
  }
}

/***/ })
],[13]);
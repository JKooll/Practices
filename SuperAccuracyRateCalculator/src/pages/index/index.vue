<template>
  <div id="wrapper">
    <div id="app">
      <div class="currency-list">
        <div class="currency-list-item" v-for="(item, index) of selectedCountryOrAreas" :key="index" @click="baseCurrency = item.alpha2Code">
          <div class="currency-list-item-col"><image :src="item.flag" mode="widthFix" style="width: 32px;"></image></div>
          <div class="currency-list-item-col">{{item.currencies[0].code}} {{item.currencies[0].symbol}}</div>
          <div class="currency-list-item-col">{{item.displayValue}}</div>
          <div class="currency-list-item-col"><radio class="radio" :checked="baseCurrency === item.alpha2Code"></radio></div>
        </div>
      </div>
      <div class="key-pad">
        <button class="key key-clear operation-key" @click="clear()">C</button>
        <button class="key digit-key" @click="inputDigit(7)">7</button>
        <button class="key digit-key" @click="inputDigit(8)">8</button>
        <button class="key digit-key" @click="inputDigit(9)">9</button>
        <button class="key operation-key" @click="refreshExchangeRate()"><i-icon type="refresh" clor="#FFFFFF" size="53" /></button>
        <button class="key digit-key" @click="inputDigit(4)">4</button>
        <button class="key digit-key" @click="inputDigit(5)">5</button>
        <button class="key digit-key" @click="inputDigit(6)">6</button>
        <button class="key operation-key key-calculator" @click="openCalculator()"><image style="width: 53px;" mode="widthFix" src="../../static/images/calculator.png"></image></button>
        <button class="key digit-key" @click="inputDigit(1)">1</button>
        <button class="key digit-key" @click="inputDigit(2)">2</button>
        <button class="key digit-key" @click="inputDigit(3)">3</button>
        <button class="key key-0 digit-key" @click="inputDigit(0)">0</button>
        <button class="key digit-key" @click="inputDot()">●</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      countryOrAreas: null,
      selectedCountryOrAreas: null,
      allow_currency_alpha2Code: ['CN', 'US', 'JP', 'HK', 'GB', 'CA', 'AU', 'TW', 'MO', 'KR', 'RU', 'MY', 'SE'],
      exchange_rates: null,
      baseCurrency: 'CN'
    }
  },
  methods: {
    // 请求国家或地区列表
    requestCountryOrAreas (successCallback) {
      wx.request({
        url: 'https://restcountries.eu/rest/v2/all?fields=alpha2Code;flag;currencies',
        success (res) {
          for (let i in res.data) {
            if (!res.data[i].value) {
              res.data[i]['displayValue'] = '0'
            }
          }
          successCallback(res)
        }
      })
    },
    openCalculator () {
      let that = this
      wx.navigateTo({
        url: '/pages/calculator/main',
        events: {
          acceptDataFromOpenedPage: function (data) {
            let baseCountryOrArea = that.getBaseCurrencyCountryOrArea()
            that.setCountryOrAreaValue(baseCountryOrArea, data)
          }
        }
      })
    },
    inputDigit (digit) {
      let baseCurrencyCountryOrArea = this.getBaseCurrencyCountryOrArea()
      baseCurrencyCountryOrArea.displayValue = baseCurrencyCountryOrArea.displayValue === '0' ? String(digit) : baseCurrencyCountryOrArea.displayValue + String(digit)
      this.refreshCurrency()
    },
    inputDot () {
      let baseCurrencyCountryOrArea = this.getBaseCurrencyCountryOrArea()
      if (!(/\./).test(baseCurrencyCountryOrArea.displayValue)) {
        baseCurrencyCountryOrArea.displayValue += '.'
      }
      this.refreshCurrency()
    },
    clear () {
      let baseCurrencyCountryOrArea = this.getBaseCurrencyCountryOrArea()
      baseCurrencyCountryOrArea.displayValue = '0'
      baseCurrencyCountryOrArea.value = 0
      this.refreshCurrency()
    },
    refreshExchangeRate () {
      this.requestExchangeRates()
    },
    getBaseCurrencyCountryOrArea () {
      for (let index in this.selectedCountryOrAreas) {
        if (this.selectedCountryOrAreas[index].alpha2Code === this.baseCurrency) {
          return this.selectedCountryOrAreas[index]
        }
      }
      return null
    },
    refreshCurrency () {
      if (!this.exchange_rates) {
        return
      }
      let baseCountryOrArea = this.getBaseCurrencyCountryOrArea()
      for (let index in this.selectedCountryOrAreas) {
        let targetCountryOrArea = this.selectedCountryOrAreas[index]
        if (targetCountryOrArea.alpha2Code === this.baseCurrency) {
          continue
        }
        let baseCurrencyCode = baseCountryOrArea.currencies[0].code
        let baseCurrencyValue = this.getCountryOrAreaValue(baseCountryOrArea)
        let targetCurrencyCode = targetCountryOrArea.currencies[0].code
        let targetValue = baseCurrencyValue / this.exchange_rates[baseCurrencyCode] * this.exchange_rates[targetCurrencyCode]
        this.setCountryOrAreaValue(targetCountryOrArea, targetValue)
      }
    },
    getCountryOrAreaValue (countryOrArea) {
      return parseFloat(countryOrArea.displayValue)
    },
    setCountryOrAreaValue (countryOrArea, value) {
      if (value === 0) {
        countryOrArea.displayValue = String(0)
      } else {
        countryOrArea.displayValue = String(value.toFixed(2))
      }
    },
    requestExchangeRates () {
      let that = this
      wx.request({
        url: 'http://data.fixer.io/api/latest',
        data: {
          access_key: '82826d4a20e318d3168e40eb27817912',
          format: 1
        },
        success (res) {
          that.exchange_rates = res.data.rates
          wx.setStorage({
            key: 'exchange_rates',
            data: {
              rates: res.data.rates,
              timestamp: +new Date()
            }
          })
        }
      })
    }
  },
  onLoad () {
    // get all country or areas list list
    let that = this
    wx.getStorage({
      key: 'countryOrAreas',
      success (res) {
        that.countryOrAreas = res.data
      },
      fail () {
        that.requestCountryOrAreas(function (res) {
          that.countryOrAreas = []
          for (let index in res.data) {
            let currentCurrencyCode = res.data[index].alpha2Code
            if (that.allow_currency_alpha2Code.includes(currentCurrencyCode)) {
              that.countryOrAreas.push(res.data[index])
              console.log(res.data[index].displayValue)
            }
          }
          wx.setStorage({
            key: 'countryOrAreas',
            data: that.countryOrAreas
          })
        })
      }
    })

    // get selected list
    wx.getStorage({
      key: 'selectedCountryOrAreas',
      success (res) {
        that.selectedCountryOrAreas = res.data
      },
      fail (res) {
        wx.request({
          url: 'https://restcountries.eu/rest/v2/all?fields=alpha2Code;flag;currencies',
          success (res) {
            that.requestCountryOrAreas(function (res) {
              that.selectedCountryOrAreas = []
              for (let i = 0; i < 5; i++) {
                for (let index in res.data) {
                  let currentCurrencyCode = res.data[index].alpha2Code
                  if (that.allow_currency_alpha2Code[i] === currentCurrencyCode) {
                    that.selectedCountryOrAreas.push(res.data[index])
                  }
                }
              }
              wx.setStorage({
                key: 'selectedCountryOrAreas',
                data: that.selectedCountryOrAreas
              })
            })
          }
        })
      }
    })

    // get base currency contryorarea alpha2Coe
    wx.getStorage({
      key: 'baseCurrency',
      success (res) {
        that.baseCurrency = res.data
      },
      fail () {
        that.baseCurrency = that.allow_currency_alpha2Code[0]
        wx.setStorage({
          key: 'baseCurrency',
          data: that.baseCurrency
        })
      }
    })

    // get currency value
    wx.getStorage({
      key: 'currencyValue',
      success (res) {
        that.currentCurrencyCode = res.data
      },
      fail () {
        that.currencyValue = 0
        wx.setStorage({
          key: 'currencyValue',
          data: that.currentCurrencyCode
        })
      }
    })

    // 获取汇率列表
    wx.getStorage({
      key: 'exchange_rates',
      success (res) {
        let timestamp = res.data.timestamp
        let currentTimestamp = +new Date()
        if (Math.abs(currentTimestamp - timestamp) > 30 * 60 * 1000) {
          that.requestExchangeRates()
        }
      },
      fail () {
        that.requestExchangeRates()
      }
    })
  }
}
</script>

<style>
  html {
    box-sizing: border-box;
  }

  *, *::before, *::after {
    box-sizing: inherit;
  }

  body {
    font: 100 14px 'Roboto';
  }

  html, body {
    margin: 0; 
    height: 100%; 
    overflow: hidden;
  }

  button::after {
    border-radius: 0;
  }

  .currency-list {
    height: 50%;
  }

  .currency-list .currency-list-item {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    height: 20%;
  }

  .currency-list .currency-list-item .currency-list-item-col {
    display: flex;
    text-align: center;
    align-items: center;
    justify-content: center;
    width: 100%;
  }

  .key-pad {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    height: 50%;
    width: 100%;
  }

  .key {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    border-radius: 0;
  }

  .key:active {
    box-shadow: inset 0px 0px 80px 0px rgba(0, 0, 0, 0.25);
  }

  .key-pad .key-calculator {
    grid-row-start: 3;
    grid-row-end: 5;
  }

  .key-pad .key-0 {
    grid-column-start: 2;
    grid-column-end: 4;
  }

  #wrapper {
    height: 100vh;
  }

  #app {
    width: 100%;
    height: 100%;
    position: relative;
  }

  .key-pad .digit-key {
    background: #e0e0e7;
    font-size: 2.25em;
  }

  .key-pad .operation-key {
    background: linear-gradient(to bottom, rgba(252, 156, 23, 1) 0%, rgba(247, 126, 27, 1) 100%);
    font-size: 3em;
    color: #ffffff;
  }
</style>
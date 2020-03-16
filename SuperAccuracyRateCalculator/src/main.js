import Vue from 'vue'
import App from './App'

Vue.config.productionTip = false
App.mpType = 'app'

const app = new Vue(App)
app.$mount()

if (process.env.NODE_ENV === 'development') {
  global.baseUri = 'http://ww.man-ing.test'
} else {
  global.baseUri = 'https://www.man-ing.com'
}

wx.cloud.init({
  env: 'huanbicalculator-8e4im'
})

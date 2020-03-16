<template>
  <div id="wrapper">
    <div id="app">
      <div class="calculator">
        <div class="calculator-display">
          <div class="auto-scaling-text">
            {{displayValue}}
          </div>
        </div>
        <div class="calculator-keypad">
          <div class="calculator-row">
            <button class="calculator-key function-key" @click="clear()">{{clearText}}</button>
            <button class="calculator-key function-key" @click="toggleSign()">±</button>
            <button class="calculator-key function-key" @click="inputPercent()">%</button>
            <button class="calculator-key operator-key" @click="performOperation('/')">÷</button>
          </div>
          <div class="calculator-row">
            <button class="calculator-key digit-key key-7" @click="inputDigit(7)">7</button>
            <button class="calculator-key digit-key key-8" @click="inputDigit(8)">8</button>
            <button class="calculator-key digit-key key-9" @click="inputDigit(9)">9</button>
            <button class="calculator-key operator-key" @click="performOperation('*')">×</button>
          </div>
          <div class="calculator-row">
            <button class="calculator-key digit-key key-4" @click="inputDigit(4)">4</button>
            <button class="calculator-key digit-key key-5" @click="inputDigit(5)">5</button>
            <button class="calculator-key digit-key key-6" @click="inputDigit(6)">6</button>
            <button class="calculator-key operator-key" @click="performOperation('-')">−</button>
          </div>
          <div class="calculator-row">
            <button class="calculator-key digit-key key-1" @click="inputDigit(1)">1</button>
            <button class="calculator-key digit-key key-2" @click="inputDigit(2)">2</button>
            <button class="calculator-key digit-key key-3" @click="inputDigit(3)">3</button>
            <button class="calculator-key operator-key" @click="performOperation('+')">+</button>
          </div>
          <div class="calculator-row">
            <button class="calculator-key digit-key key-0" @click="inputDigit(0)">0</button>
            <button class="calculator-key digit-key key-dot" @click="inputDot()">●</button>
            <button class="calculator-key operator-key" @click="performOperation('=')">=</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const CalculatorOperations = {
  '/': function (prevValue, nextValue) {
    return prevValue / nextValue
  },
  '*': function (prevValue, nextValue) {
    return prevValue * nextValue
  },
  '+': function (prevValue, nextValue) {
    return prevValue + nextValue
  },
  '-': function (prevValue, nextValue) {
    return prevValue - nextValue
  },
  '=': function (prevValue, nextValue) {
    return nextValue
  }
}
export default {
  data () {
    return {
      value: null,
      displayValue: '0',
      operator: null,
      waitingForOperand: false,
      eventChannel: null
    }
  },
  methods: {
    clearAll () {
      this.value = null
      this.displayValue = '0'
      this.operator = null
      this.waitingForOperand = false
    },
    clearDisplay () {
      this.displayValue = '0'
    },
    clearLastChar () {
      this.displayValue = this.displayValue.substring(0, this.displayValue.length - 1) || '0'
    },
    clear () {
      if (this.displayValue !== '0') {
        this.clearDisplay()
      } else {
        this.clearAll()
      }
    },
    toggleSign () {
      let newValue = parseFloat(this.displayValue) * -1
      this.displayValue = String(newValue)
    },
    inputPercent () {
      let currentValue = parseFloat(this.displayValue)
      if (currentValue === 0) {
        return
      }
      let fixedDigits = this.displayValue.replace(/^-?\d*\./, '')
      let newValue = parseFloat(this.displayValue) / 100
      this.displayValue = String(newValue.toFixed(fixedDigits.length + 2))
    },
    inputDot () {
      if (!(/\./).test(this.displayValue)) {
        this.displayValue += '.'
        this.waitingForOperand = false
      }
    },
    performOperation (nextOperator) {
      let inputValue = parseFloat(this.displayValue)
      if (this.value == null) {
        this.value = inputValue
      } else if (this.operator) {
        let currentValue = this.value || 0
        let newValue = CalculatorOperations[this.operator](currentValue, inputValue)
        this.value = newValue
        this.displayValue = String(newValue)
      }

      this.waitingForOperand = true
      this.operator = nextOperator
    },
    inputDigit (digit) {
      if (this.waitingForOperand) {
        this.displayValue = String(digit)
        this.waitingForOperand = false
      } else {
        this.displayValue = this.displayValue === '0' ? String(digit) : this.displayValue + digit
      }
    }
  },
  computed: {
    clearText () {
      return this.displayValue !== '0' ? 'C' : 'AC'
    }
  },
  watch: {
    displayValue (val) {
      if (val !== null && this.eventChannel) {
        this.eventChannel.emit('acceptDataFromOpenedPage', parseFloat(val))
      }
    }
  },
  onLoad (option) {
    this.eventChannel = this.$mp.page.getOpenerEventChannel()
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

#wrapper {
  height: 100vh;
}

#app {
  width: 100%;
  height: 100%;
  position: relative;
}

.calculator {
  width: 100%;
  height: 100%;
  background: black;
}

.calculator-display {
  width: 100%;
  height: 25%;
  color: white;
  background: #1c191c;
  font-size: 6em;
}

.calculator-display .auto-scaling-text {
  height: 100%;
  float:right;
  padding: 0 30px;
  line-height: 180%;
}

.calculator .calculator-key {
  display: inline-block;
  background: none;
  border: none;
  border-radius: 0;
  padding: 0;
  font-family: inherit;
  user-select: none;
  cursor: pointer;
  outline: none;

  border-top: 1px solid #777;
  border-right: 1px solid #666;  
  text-align: center;
}

.calculator .calculator-key:active {
  box-shadow: inset 0px 0px 80px 0px rgba(0,0,0,0.25);
}

.calculator .calculator-keypad {
  height: 75%;
  width: 100%;
}

.calculator .calculator-row {
  height: 20%;
  width: 100%;
}

.calculator .calculator-key {
  width: 25%;
  height: 100%;
}

.calculator .key-0 {
  width: 50%;
}

.calculator .key-dot {
  font-size: 0.75em;
}

.calculator .digit-key {
  background: #e0e0e7;
  font-size: 2.25em;
  line-height: 300%;
}

.calculator .function-key {
  background: linear-gradient(to bottom, rgba(202, 202, 204, 1) 0%, rgba(196, 194, 204, 1) 100%);
  font-size: 2em;
  line-height: 300%;
}

.calculator .operator-key {
  background: linear-gradient(to bottom, rgba(252, 156, 23, 1) 0%, rgba(247, 126, 27, 1) 100%);
  font-size: 3em;
  line-height: 200%;
  color: white;
}
</style>
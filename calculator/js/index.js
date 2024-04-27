import { Calculator, Operation } from "./calculator.js";

let input = document.querySelector(".input");
let numbers = document.querySelectorAll(".number");
let multiply = document.querySelector(".multiply");
let divide = document.querySelector(".divide");
let add = document.querySelector(".add");
let substract = document.querySelector(".substract");
let equal = document.querySelector(".equal");
let deletebtn = document.querySelector(".delete");
let clear = document.querySelector(".clear");

let currentDisplay = "";
let _operand = [];
let opts = [multiply, divide, add, substract];

document.addEventListener("DOMContentLoaded", () => {
   numbers.forEach((btn) => {
      btn.addEventListener('click', () => {
         handleNumberClick(btn.innerHTML);
      })
   })

   opts.forEach((opt) => {
      opt.addEventListener('click', () => {
         handleOperandClick(opt.innerHTML);
      })
   })

   deletebtn.addEventListener('click', () => {
      handleDelete();
   })

   clear.addEventListener('click', () => {
      handleClear();
   })

   equal.addEventListener('click', () => {
      handleEqual();
   })
})

function handleNumberClick(number) {
   currentDisplay += number;
   input.innerHTML = currentDisplay;
}

function handleOperandClick(operand) {
   if (currentDisplay.length === 0 && operand === '-') {
      currentDisplay += operand;
      input.innerHTML = currentDisplay;
      return;
   }

   if (!_operand[0]) {
      currentDisplay += operand;
      input.innerHTML = currentDisplay;
      _operand[0] = true;
      _operand[1] = currentDisplay.length;
   }
}

function handleDelete() {
   currentDisplay = currentDisplay.slice(0, -1);
   input.innerHTML = currentDisplay;
}

function handleClear() {
   currentDisplay = "";
   _operand = [];
   input.innerHTML = currentDisplay;
}

function handleEqual() {
   calculate();
   input.innerHTML = currentDisplay;
}

function calculate() {
   let operandIdx = _operand[1] - 1;
   let operand = currentDisplay[operandIdx];
   let num1 = getFirstNum(currentDisplay.slice(0, operandIdx));
   let num2 = parseInt(currentDisplay.substring(operandIdx + 1, currentDisplay.length));

   let operation = new Operation(num1, num2, operand);
   let calculator = new Calculator(operation);

   currentDisplay = calculator.calculate().toString();
}

function getFirstNum(num) {
   return num[0] === '-' ? (parseInt(num.slice(1, num.length)) * -1) : parseInt(num);
}

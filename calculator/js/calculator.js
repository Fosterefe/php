import * as arirthmetic from "./arithmetic.js";

export class Operation {
   constructor(num1, num2, typeOperand) {
      this.num1 = num1;
      this.num2 = num2;
      this.typeOperand = typeOperand;
   }
}

export class Calculator {
   /**
 * @param {Operation} operation 
 */
   constructor(operation) {
      this.operation = operation;
   }

   calculate() {
      let operation = this.operation.typeOperand;
      let res;
      switch (operation) {
         case "+":
            res = arirthmetic.add(this.operation.num1, this.operation.num2);
            break;
         case "-":
            res = arirthmetic.substract(this.operation.num1, this.operation.num2);
            break;
         case "/":
            res = arirthmetic.divide(this.operation.num1, this.operation.num2);
            break;
         case "*":
            res = arirthmetic.multiply(this.operation.num1, this.operation.num2);
            break;
      }
      return res;
   }
}

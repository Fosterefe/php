export function add(num1, num2) {
    while(num2 !== 0) {
        let c = num1 & num2;
        num1 = num1  ^ num2;
        num2 = c << 1;
    }
    return num1;
}

export function substract(num1, num2) {
    while(num2 !== 0) {
        let b = (~num1) & num2;
        num1 = num1  ^ num2;
        num2 = b << 1;
    }
    return num1;
}

export function multiply(num1, num2) {
    let res = 0;
    for(let i = 0; i < num2; i++) {
        res = add(res, num1);
    }
    return res;
}

export function divide(num1, num2) {
    if(num2 === 0) {
        return "No se puede dividir por 0";
    }
    let res = 0;
    let temp = num1;

    while(temp > 0) {
        temp = substract(temp - num2);
        res = add(res, 1);
    }
    return res;
}
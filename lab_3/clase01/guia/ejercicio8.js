"use strict";
console.log(factorial(4));
console.log(factorial(0));
console.log(factorial(3));
console.log(factorial(8));
function factorial(num) {
    var acum = 1;
    while (num > 1) {
        acum *= num;
        num--;
    }
    return acum;
}
//# sourceMappingURL=ejercicio8.js.map
"use strict";
mostrarPrimos(20);
function mostrarPrimos(cant) {
    var cont = 0;
    var i = 0;
    while (cont < cant) {
        if (esPrimo(i)) {
            console.log(i + " Es un numero primo");
            cont++;
        }
        i++;
    }
}
function esPrimo(num) {
    var retorno = false;
    if (num > 1) {
        retorno = true;
        for (var i = 2; i < num; i++) {
            if (num % i == 0) {
                retorno = false;
                break;
            }
        }
    }
    return retorno;
}
//# sourceMappingURL=ejercicio7.js.map
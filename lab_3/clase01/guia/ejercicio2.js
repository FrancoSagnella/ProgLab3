"use strict";
var meses = ["enero", "febrero", "marzo",
    "abril", "mayo", "junio", "julio",
    "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
MostrarMeses(meses);
function MostrarMeses(array) {
    for (var i = 0; i <= 11; i++) {
        console.log("Mes: " + array[i] + " Numero: " + [i + 1]);
    }
}
//# sourceMappingURL=ejercicio2.js.map
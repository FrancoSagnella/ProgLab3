"use strict";
miFuncion(6, "hola");
miFuncion(-2);
miFuncion(7);
miFuncion(-4, "hola");
function miFuncion(num, cadena) {
    var absolute = Math.abs(num);
    if (cadena != null) {
        for (var i = 0; i < absolute; i++) {
            console.log(cadena);
        }
    }
    else {
        if (absolute == num) {
            console.log(-num);
        }
        else {
            console.log(absolute);
        }
    }
}
//# sourceMappingURL=ejercicio3.js.map
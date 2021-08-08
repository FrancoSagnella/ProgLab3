"use strict";
ejercicio11("La ruta nos aporto otro paso natural");
function ejercicio11(cadena) {
    var sinEspacios = cadena.toLowerCase().split(" ").join("");
    var invertida = sinEspacios.split("").reverse().join("");
    if (sinEspacios == invertida) {
        console.log("Es un polindromo: " + cadena);
    }
    else {
        console.log("No es un polindromo: " + cadena);
    }
}
//# sourceMappingURL=ejercicio11.js.map
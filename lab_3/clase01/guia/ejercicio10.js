"use strict";
ejercicio10("hola");
ejercicio10("HOLA");
ejercicio10("HoLa");
function ejercicio10(cadena) {
    if (cadena == cadena.toLowerCase()) {
        console.log("La cadena esta formada toda por minusculas: " + cadena);
    }
    else if (cadena == cadena.toUpperCase()) {
        console.log("La cadena esta formada solo por mayusculas: " + cadena);
    }
    else {
        console.log("La cadena esta formada por una mezcla de mayusculas y minusculas: " + cadena);
    }
}
//# sourceMappingURL=ejercicio10.js.map
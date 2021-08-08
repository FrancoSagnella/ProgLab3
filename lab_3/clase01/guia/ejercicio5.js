"use strict";
var nombre = "Franco";
var apellido = "Sagnella";
console.log(mostrarNombreApellido(nombre, apellido));
function mostrarNombreApellido(nombre, apellido) {
    return apellido.toUpperCase() + ", " + nombre[0].toUpperCase() + nombre.slice(1).toLowerCase();
    //Podria tambien usar nombre.charAt(indice) que me devuelve un indice del string, en vez de
    //acceder directamente al indice
    //slice(indice) me devuelve el contenido del string desde el indice que le indico, hacia delante
}
//# sourceMappingURL=ejercicio5.js.map
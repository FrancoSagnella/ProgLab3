"use strict";
//ARRAY.MAP
//#1.- SE QUIERE CALCULAR EL CUADRADO DE CADA ELEMENTO
var numeros = [1, 2, 3, 4, 5];
var cuadrados = [];
//a.- FORMA 'TRADICIONAL'
for (var i = 0; i < numeros.length; i++) {
    cuadrados[i] = numeros[i] * numeros[i];
}
console.log(cuadrados);
//b.- CON MAP
cuadrados = numeros.map(function (numero) {
    return numero * numero;
});
console.log(cuadrados);
//c.- CON MAP Y =>
cuadrados = numeros.map(function (numero) { return numero * numero; });
console.log(cuadrados);
//#2.- SE QUIERE SABER LOS NOMBRES DE LOS PRODUCTOS
var productos = [
    { id: "1", nombre: "Remera", categoria: "Ropa" },
    { id: "2", nombre: "Zapatillas", categoria: "Accesorios" },
    { id: "3", nombre: "Zapatos", categoria: "Accesorios" },
    { id: "4", nombre: "Shorts", categoria: "Ropa" },
    { id: "5", nombre: "Corbata", categoria: "Ropa" }
];
//a.- FORMA 'TRADICIONAL'
var nombreDeProductos = [];
for (var i = 0; i < productos.length; i++) {
    nombreDeProductos.push(productos[i].nombre);
}
console.log(nombreDeProductos);
//b.- CON MAP
nombreDeProductos = productos.map(function (producto, index, array) {
    return producto.nombre;
});
console.log(nombreDeProductos);
//c.- CON MAP Y =>
nombreDeProductos = productos.map(function (producto, index, array) { return producto.nombre; });
console.log(nombreDeProductos);
//# sourceMappingURL=map.js.map
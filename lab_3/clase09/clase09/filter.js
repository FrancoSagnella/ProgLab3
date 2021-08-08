"use strict";
//ARRAY.FILTER
//#1.- SE QUIERE OBTENER TODOS LOS IMPARES
var valores = [1, 2, 3, 4, 5];
var impares = [];
//a.- FORMA 'TRADICIONAL'
var cont = 0;
for (var i = 0; i < valores.length; i++) {
    if (valores[i] % 2 === 1) {
        impares[cont] = valores[i];
        cont++;
    }
}
console.log(impares);
//b.- CON FILTER
impares = valores.filter(function (numero) {
    return numero % 2 === 1;
});
console.log(impares);
//c.- CON FILTER Y =>
impares = valores.filter(function (numero) { return numero % 2 === 1; });
console.log(impares);
//#2.- SE QUIERE OBTENER LOS PRODUCTOS DE LA CATEGORIA 'ACCESORIOS'
var productosStock = [
    { id: "1", nombre: "Remera", categoria: "Ropa", stock: 150 },
    { id: "2", nombre: "Zapatillas", categoria: "Accesorios", stock: 500 },
    { id: "3", nombre: "Zapatos", categoria: "Accesorios", stock: 200 },
    { id: "4", nombre: "Shorts", categoria: "Ropa", stock: 950 },
    { id: "5", nombre: "Corbata", categoria: "Ropa", stock: 800 }
];
//a.- FORMA 'TRADICIONAL'
var productosAccesorios = [];
for (var i = 0; i < productosStock.length; i++) {
    if (productosStock[i].categoria === "Accesorios") {
        productosAccesorios.push(productosStock[i]);
    }
}
console.log(productosAccesorios);
//b.- CON FILTER
productosAccesorios = productosStock.filter(function (producto, index, array) {
    return producto.categoria === "Accesorios";
});
console.log(productosAccesorios);
//c.- CON FILTER Y =>
productosAccesorios = productosStock.filter(function (producto, index, array) { return producto.categoria === "Accesorios"; });
console.log(productosAccesorios);
//# sourceMappingURL=filter.js.map
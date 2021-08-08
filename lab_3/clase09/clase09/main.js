"use strict";
var DATA = (function () {
    var d = [
        { "nombre": "Juana", "sexo": "F", "edad": 25 },
        { "nombre": "Roberto", "sexo": "M", "edad": 40 },
        { "nombre": "Julian", "sexo": "M", "edad": 35 }
    ];
    return d;
})();
var usuarios = DATA;
for (var i = 0; i < usuarios.length; i++) {
    console.log(usuarios[i].nombre + " - " + usuarios[i].sexo + " - " + usuarios[i].edad);
}
var soloNombres = usuarios.map(function (item, i, usuarios) {
    return item.nombre;
});
console.log(soloNombres);
var inicialJota = usuarios.filter(function (usuario) {
    return usuario.nombre.substr(0, 1) === "J";
});
console.log(inicialJota);
var edadUsuarios = usuarios.reduce(function (anterior, siguiente) {
    return anterior + siguiente.edad;
}, 0);
console.log(edadUsuarios);
var nombresUsuariosFemeninos = function () {
    return DATA
        .filter(function (user) {
        return user.sexo === 'F';
    })
        .map(function (user) {
        return user.nombre;
    });
};
console.log(nombresUsuariosFemeninos);
//# sourceMappingURL=main.js.map
let DATA = (function() {

    let d : any[] = [
        {"nombre" : "Juana", "sexo" : "F", "edad" : 25},
        {"nombre" : "Roberto", "sexo" : "M", "edad" : 40},
        {"nombre" : "Julian", "sexo" : "M", "edad" : 35}
    ];

    return d;
})();

let usuarios = DATA;

for(let i=0; i<usuarios.length; i++){
    console.log(usuarios[i].nombre + " - " + usuarios[i].sexo + " - " + usuarios[i].edad);
}

let soloNombres = usuarios.map(function(item, i, usuarios){
    return item.nombre;
});
console.log(soloNombres);


let inicialJota = usuarios.filter(function(usuario){
    return usuario.nombre.substr(0,1) === "J";
});
console.log(inicialJota);


let edadUsuarios = usuarios.reduce(function(anterior, siguiente){
    return anterior + siguiente.edad;
},0);
console.log(edadUsuarios);


let nombresUsuariosFemeninos = function () {
    return DATA
      .filter(function (user) {
        return user.sexo === 'F';
      })
      .map(function (user) {
        return user.nombre;
      });
  };
console.log(nombresUsuariosFemeninos);

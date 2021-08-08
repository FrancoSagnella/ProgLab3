"use strict";
/// <reference path="./alumno.ts" />
var TestPrueba;
(function (TestPrueba) {
    var alumnos = new Array();
    alumnos.push(new Prueba.Alumno(100, "Sagnella", "Franco"));
    alumnos.push(new Prueba.Alumno(101, "Perez", "Pepito"));
    alumnos.forEach(Mostrar);
    function Mostrar(a) {
        console.log(a.ToString());
    }
})(TestPrueba || (TestPrueba = {}));
//# sourceMappingURL=main.js.map
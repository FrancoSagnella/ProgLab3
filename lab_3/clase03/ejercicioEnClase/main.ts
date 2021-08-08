/// <reference path="./alumno.ts" />

namespace TestPrueba
{
    let alumnos : Array<Prueba.Persona> = new Array<Prueba.Persona>();

    alumnos.push(new Prueba.Alumno(100, "Sagnella", "Franco"));
    alumnos.push(new Prueba.Alumno(101, "Perez", "Pepito"));

    alumnos.forEach(Mostrar);

    function Mostrar(a : Prueba.Persona):void
    {
        console.log(a.ToString());
    }
}
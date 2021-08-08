/// <reference path="./alumno.ts" />

namespace Manejador
{
    export function CrearAlumno():void
    {
        let apellido:string = (<HTMLInputElement> document.getElementById("txtApellido")).value;
        let nombre:string = (<HTMLInputElement> document.getElementById("txtNombre")).value;
        let legajo:number = (Number)((<HTMLInputElement> document.getElementById("txtLegajo")).value);

        let alumno : Prueba.Alumno = new Prueba.Alumno(legajo, apellido, nombre);

        console.log(alumno.ToString());
        alert(alumno.ToString());
    }
}
///<reference path="./persona.ts" />

namespace Prueba
{
    export class Alumno extends Persona
    {
        protected legajo : number;

        public constructor(legajo : number, apellido : string, nombre : string)
        {
            super(apellido, nombre);
            this.legajo = legajo;
        }

        public get Legajo()
        {
            return this.legajo;
        }

        public set Legajo(legajo : number)
        {
            this.legajo = legajo;
        }

        public ToString() : string
        {
            return super.ToString() + " - " + this.legajo;
        }
    }
}
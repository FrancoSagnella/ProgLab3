namespace Prueba
{
    export class Persona
    {
        protected apellido : string;
        protected nombre : string;

        public constructor(apellido : string, nombre : string)
        {
            this.apellido = apellido;
            this.nombre = nombre;
        }

        public get Apellido()
        {
            return this.apellido;
        }
        public set Apellido(apellido : string)
        {
            this.apellido = apellido;
        }

        public get Nombre()
        {
            return this.nombre;
        }
        public set Nombre(nombre : string)
        {
            this.nombre = nombre;
        }

        public ToString() : string
        {
            return this.nombre + " - " + this.apellido;
        }
    }
}
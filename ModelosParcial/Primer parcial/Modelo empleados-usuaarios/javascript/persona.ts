namespace Entidades{

    export class Persona
    {
        public nombre : string;
        public correo : string;
        public clave : string;

        public constructor (nombre : string, correo : string, clave : string){
            this.nombre = nombre;
            this.correo = correo;
            this.clave = clave;
        }

        public ToString()
        {
            return JSON.stringify(this);
        }
        public ToJSON()
        {
            return JSON.parse(this.ToString());
        }
        /*public ToString() : string{
            //Tiene que estar entre los tildes inversos para poder hacer ${variable}
            //si no tendria que concatenar todo
            return  `"nombre" : "${this.nombre}", "correo" : "${this.correo}", "clave" : "${this.clave}"`;
        }

        public ToJSON() 
        {
            return JSON.parse("{"+this.ToString()+"}");
        }*/
    }
}
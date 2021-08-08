/// <reference path="./persona.ts" /> 

namespace Entidades{

    export class Usuario extends Persona
    {
        public id : number;
        public id_perfil : number;
        public perfil : string;

        public constructor (nombre : string = "", correo : string, clave : string, id : number = 0, id_perfil : number = 0, perfil : string = "")
        {
            //llamo al constructor padre
            super(nombre, correo, clave);
            this.id = id;
            this.id_perfil = id_perfil;
            this.perfil = perfil;
        }

        public ToString()
        {
            return JSON.stringify(this);
        }
        public ToJSON()
        {
            return JSON.parse(this.ToString());
        }
        /*public ToString() : string
        {
            return `"id" : "${this.id}", ${super.ToString()}, "id_perfil" : "${this.id_perfil}", "perfil" : "${this.perfil}"`;
        }

        public ToJSON() 
        {
            return JSON.parse("{"+this.ToString()+"}");
        }*/

        /* QUIERO PROBAR SI ESTO FUNCA BIEN
        public ToString() : string
        {
            return this.ToJSON().toString();
        }

        public ToJSON() : string
        {
            return JSON.stringify(this);
        }
        */ 
    }
}
/// <reference path="./usuario.ts" /> 

namespace Entidades{
    export class Empleado extends Usuario
    {
        public sueldo : number;
        public foto : string;
    
        public constructor (nombre : string, correo : string, clave : string, id : number, id_perfil : number, perfil : string, sueldo : number, foto : string)
        {
            //llamo al constructor padre
            super(nombre, correo, clave, id, id_perfil, perfil);
            this.sueldo = sueldo;
            this.foto = foto;
        }

        public ToString()
        {
            return JSON.stringify(this);
        }
        public ToJSON()
        {
            return JSON.parse(this.ToString());
        }
    }
}
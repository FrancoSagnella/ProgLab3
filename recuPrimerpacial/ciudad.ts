
namespace Entidades {

    export class Ciudad {


        id : number;
        nombre : string;
        poblacion : number;
        pais : string;
        //foto : string;


        
        public constructor(id: number, nombre: string, poblacion: number, pais : string) {
            this.id = id;
            this.nombre = nombre;
            this.poblacion = poblacion;
            this.pais = pais;
        }


        public ToJSON(): any {

            let retornoJSON= `{"id":"${this.id}","nombre":${this.nombre},"poblacion":"${this.poblacion}","pais":${this.pais}"} `;
            return JSON.parse(retornoJSON);

        }





    }
}
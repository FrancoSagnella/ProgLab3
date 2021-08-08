///<reference path="Producto.ts"/>
namespace Entidades
{
   export class ProductoEnVasado extends Producto
    {
        public id:number;
        public codigoBarra:number;
        public precio:number;
        public pathFoto:string

        public constructor(nombre:string,origen:string,id:number,codigoBarra:number,precio:number,pathFoto:string)
        {
            super(nombre,origen)
            this.id=id;
            this.codigoBarra=codigoBarra;
            this.precio=precio;
            this.pathFoto=pathFoto;
        }
        public ToString()
        {
           // return `"id":"${this.id}","codigoBarra":"${this.codigoBarra}","precio":"${this.precio}","pathFoto":"${this.pathFoto}"`
           return JSON.stringify(this);

        }
        public ToJSon() {
            return JSON.parse(this.ToString());
        }

    }
}
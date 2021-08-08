namespace Entidades
{
  export  class Producto
    {
        public nombre:string;
        public origen:string;

        public constructor(nombre:string,origen:string)
        {
            this.nombre=nombre;
            this.origen=origen;
        }
        public ToString()
        {
           // return `"nombre":"${this.nombe}","origen":"${this.origen}",`
           return JSON.stringify(this);

        }
        public ToJSon() {
            return JSON.parse(this.ToString());
        }

    }
}
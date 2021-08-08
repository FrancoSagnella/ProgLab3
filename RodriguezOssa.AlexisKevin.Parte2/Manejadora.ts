///<reference path="ProductoEnvasado.ts"/>
///<reference path="ajax.ts"/>
namespace PrimerParcial
{
   export class Manejadora
    {
        public static AgregarProductoJSON()
        {
            let nombre:string=(<HTMLInputElement> document.getElementById("nombre")).value;
        let origen:string=(<HTMLInputElement> document.getElementById("cboOrigen")).value;

        let form=new FormData();
        form.append("nombre",nombre);
        form.append("origen",origen);
        let ajax =new Ajax();
        ajax.Post("./backend/AltaProductoJSON.php",
        (param:any)=>{
            alert(JSON.parse(param).mensaje);
            console.log(JSON.parse(param).mensaje);
        }
        ,form)
        }


        public static MostrarProductosJSON()
        {
            let ajax =new Ajax();
        ajax.Get("./backend/ListadoProductosJSON.php",(param:any)=>{
           let mostrar="<table><tr><th>NOMBRE</th><th>ORIGEN</th></tr>";
           let lista=JSON.parse(param);
           for(let i=0; i<lista.length;i++)
           {
            mostrar+='<tr><td>';
            mostrar+=lista[i].nombre;
            mostrar+='</td><td>';
            mostrar+=lista[i].origen;
            mostrar+='</td>';
            mostrar+='</tr>';
           }
           mostrar+="</table>";
           (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
         }           
        )
        }
        public static VerificarProductoJSON()
        {
            let nombre:string=(<HTMLInputElement> document.getElementById("nombre")).value;
            let origen:string=(<HTMLInputElement> document.getElementById("cboOrigen")).value;
            //testear con tojson
        let form=new FormData();
        form.append("origen",origen);
        form.append("nombre",nombre);
        let ajax =new Ajax();
        ajax.Post("./backend/VerificarProductoJSON.php",
        (param:any)=>{
            //alert("hola");
            alert(JSON.parse(param).mensaje);
            console.log(JSON.parse(param).mensaje);
          
        }
        ,form)
        }

        public static MostrarInfoCookie()
        {
            let nombre:string=(<HTMLInputElement> document.getElementById("nombre")).value;
            let origen:string=(<HTMLInputElement> document.getElementById("cboOrigen")).value;
            //testear con tojson
        
        let ajax =new Ajax();
        ajax.Get("./backend/MostrarCookie.php",
        (param:any)=>{
            
            alert(JSON.parse(param).mensaje);
            console.log(JSON.parse(param).mensaje);
        }
        ,`nombre=${nombre}&origen=${origen}`);
        }


        public static AgregarProductoSinFoto()
        {
            let nombre:string=(<HTMLInputElement> document.getElementById("nombre")).value;
            let origen:string=(<HTMLInputElement> document.getElementById("cboOrigen")).value;
        let codigoBarra:string=(<HTMLInputElement> document.getElementById("codigoBarra")).value;
        let precio:string=(<HTMLInputElement> document.getElementById("precio")).value;
        let producto=JSON.stringify(new Entidades.ProductoEnVasado(nombre,origen,0,parseInt(codigoBarra) ,parseInt(precio) ,""));//lo hago tipo json

        let form=new FormData();
        form.append("producto_json",producto);
      
        let ajax =new Ajax();
        ajax.Post("./backend/AgregarProductoSinFoto.php",
        (param:any)=>{
            //(<HTMLInputElement> document.getElementById("id")).value = "";
                    (<HTMLInputElement> document.getElementById("nombre")).value = "";
                    (<HTMLInputElement> document.getElementById("precio")).value = "";
                    (<HTMLInputElement> document.getElementById("codigoBarra")).value = "";
                    (<HTMLInputElement> document.getElementById("cboOrigen")).value = "1";
            alert(JSON.parse(param).mensaje);
            console.log(param);
        }
        ,form)
    
        }

        public static MostrarProductosEnvasados()
        {
            let ajax =new Ajax();
        ajax.Get("./backend/ListadoProductosEnvasados.php",(param:any)=>{
           let mostrar="<table><tr><th>ID</th><th>NOMBRE</th><th>CODIGO.B</th><th>ORIGEN</th><th>PRECIO</th><th>ACCIONES</th></tr>";
           let lista=JSON.parse(param);
           for(let i=0; i<lista.length;i++)
           {
            mostrar+='<tr><td>';
            mostrar+=lista[i].id;
            mostrar+='</td><td>';
            mostrar+=lista[i].nombre;
            mostrar+='</td><td>';           
            mostrar+=lista[i].codigoBarra;
            mostrar+='</td><td>';
            mostrar+=lista[i].origen;
            mostrar+='</td><td>';
            mostrar+=lista[i].precio;
            mostrar+='</td>';
            mostrar+="<td><input type='button' value='Borrar' class='btn btn-dark' onclick='ModeloParcial.Manejadora.EliminarUsuario("+JSON.stringify(lista[i])+")' />";
            mostrar+="<input type='button' value='Modificar' class='btn btn-danger' onclick='ModeloParcial.Manejadora.ModificarUsuario("+JSON.stringify(lista[i])+")' /></td>";
            mostrar+='</td></tr>';
           }
           mostrar+="</table>";
           (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
         }           
        )
        }
    }
}
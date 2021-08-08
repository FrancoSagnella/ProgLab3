/// <reference path="ciudad.ts"/>
///<reference path="ajax.ts"/>
/// <reference path="./node_modules/@types/jquery/index.d.ts" />

namespace RecuperatorioPrimerParcial
{
    export class Manejadora 
    {
        public static  VisualizarFoto():void
        {
            //if($("#foto").val() === "")
            if( (<HTMLInputElement>document.getElementById("foto")).value==="")
            {
              //  $("#imgFoto").attr("src", "default-avatar.png");
               (<HTMLInputElement>document.getElementById("imgFoto")).src="ciudad_default.jpg";

                return;
            }
            
            let foto = (<HTMLInputElement>document.getElementById("foto")).files;
            let reader = new FileReader();

            reader.readAsDataURL(foto[0]);

            reader.onload = function(){
              //  $("#imgFoto").attr("src", <string> reader.result);
                (<HTMLInputElement>document.getElementById("imgFoto")).src= <string> reader.result;

            }
        }

        public static AgregarCiudad()
        {
            let nombre:string=(<HTMLInputElement> document.getElementById("nombre")).value;
            let poblacion:string=(<HTMLInputElement> document.getElementById("poblacion")).value;
            let pais:string=(<HTMLInputElement> document.getElementById("cboPais")).value;
        let foto:any=(<HTMLInputElement> document.getElementById("foto"));
        let form=new FormData();
        let pob=parseInt(poblacion);
        form.append("nombre",nombre);
        form.append("poblacion", poblacion);
        form.append("pais", pais);
        form.append("foto",foto.files[0]);
 
        let ajax =new Ajax();

            ajax.Post("./BACKEND/AgregarCiudad.php",
            (param:any)=>{
                param = JSON.parse(param);
                alert(param.mensaje);
                console.log(param.mensaje);
                if(param.exito)
                {
                    Manejadora.MostrarCiudad();
                    (<HTMLInputElement> document.getElementById("nombre")).value = "";
                    (<HTMLInputElement> document.getElementById("poblacion")).value = "";
                    (<HTMLInputElement> document.getElementById("foto")).value = "";
                    (<HTMLInputElement> document.getElementById("cboPais")).value = "1";
                    (<HTMLInputElement>document.getElementById("imgFoto")).src="ciudad_default.jpg";

                }
            }
            ,form)
        }

        public static MostrarCiudad()
        {
           /* let ajax =new Ajax();
        ajax.Get("./backend/ListadoRecetas.php",(param:any)=>{
           let mostrar=param;
           
           (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
         }           
        )*/
        let nombre="dato=json";
        let ajax =new Ajax();
        ajax.Get("./BACKEND/ListadoCiudades.php",(param:any)=>{
           let mostrar="<table><tr><th>ID</th><th>NOMBRE</th><th>POBLACION.B</th><th>PAIS</th><th>FOTO</th><th>ACCIONES</th></tr>";
           let listo=JSON.parse(param);
           let lista=listo.dato;
           // let hola=param.dato;
           // let lista=JSON.parse(hola);
           for(let i=0; i<lista.length;i++)
           {
            mostrar+='<tr><td>';
            mostrar+=lista[i].id;
            mostrar+='</td><td>';
            mostrar+=lista[i].nombre;
            mostrar+='</td><td>';           
            mostrar+=lista[i].poblacion;
            mostrar+='</td><td>';
            mostrar+=lista[i].pais;
            mostrar+='</td><td>';
           
            if(lista[i].pathFoto!=null)
            {
                mostrar+="<img src='./BACKEND/ciudades/imagenes/" + lista[i].pathFoto + "' width='85' height='85'>";
  
            }

            mostrar+='</td>';
            mostrar+="<td><input type='button' value='Borrar' class='btn btn-dark' onclick='RecuperatorioPrimerParcial.Manejadora.EliminarCiudad("+JSON.stringify(lista[i])+")' />";//hace un json
            mostrar+="<input type='button' value='Modificar' class='btn btn-danger' onclick='RecuperatorioPrimerParcial.Manejadora.ModificarCiudad("+JSON.stringify(lista[i])+")' /></td>";//parse->objeto
            mostrar+='</td></tr>';
           }
           mostrar+="</table>";
           (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
         }           
        ,nombre)
        }

        public static EliminarCiudad(ciudad_json: any)
        {

            if(!confirm("Desea eliminar la ciudad seleccionado? nombre: "+ciudad_json.nombre+" pais: "+ciudad_json.pais))
            return;
            
            let ciudad = JSON.stringify(ciudad_json);
          // let producto=producto_json;
          let borrar="borrar";
            let ajax = new Ajax();
            let form = new FormData();
            form.append("ciudad_json", ciudad);
           // form.append("accion", borrar);
            ajax.Post('./BACKEND/EliminarCiudad.php',
            (param:any)=>{
                param = JSON.parse(param);
                alert(param.mensaje);
                console.log(param.mensaje);
                if(param.exito==true)
                {
                    Manejadora.MostrarCiudad();
                }
            }
            ,form);
            
        }
        public static ModificarCiudad(ciudad_json: any)
        {
            (<HTMLInputElement> document.getElementById("id_ciudad")).value = ciudad_json.id;

            (<HTMLInputElement> document.getElementById("poblacion")).value = ciudad_json.poblacion;
             (<HTMLInputElement> document.getElementById("nombre")).value = ciudad_json.nombre;
             //(<HTMLInputElement> document.getElementById("foto")).value = producto_json.pathFoto;
              (<HTMLInputElement> document.getElementById("cboPais")).value = ciudad_json.pais;
              (<HTMLImageElement>document.getElementById("imgFoto")).src ="./BACKEND/ciudades/imagenes/" + ciudad_json.pathFoto;

              (<HTMLInputElement>document.getElementById("imgFoto")).src="ciudad_default.jpg";


        }

        public static Modificar( )
        {
            let id:string=(<HTMLInputElement> document.getElementById("id_ciudad")).value;
            let nombre:string=(<HTMLInputElement> document.getElementById("nombre")).value;
            let poblacion:string=(<HTMLInputElement> document.getElementById("poblacion")).value;
        let pais:string=(<HTMLInputElement> document.getElementById("cboPais")).value;
        let foto:any=(<HTMLInputElement> document.getElementById("foto"));

       // let foto:string=(<HTMLInputElement> document.getElementById("precio")).value;
        let ciudad=JSON.stringify(new Entidades.Ciudad(parseInt(id) ,nombre,parseInt(poblacion),pais));//lo hago tipo json

        let form=new FormData();
        form.append("ciudad_json",ciudad);
        form.append("foto",foto.files[0]);

      
        let ajax =new Ajax();
        ajax.Post("./BACKEND/ModificarCiudad.php",
        (param:any)=>{
                param = JSON.parse(param);
                alert(param.mensaje);
                console.log(param.mensaje);
                if(param.exito==true)
                {

                    Manejadora.MostrarCiudad();
                    (<HTMLInputElement> document.getElementById("nombre")).value = "";
                    (<HTMLInputElement> document.getElementById("id_ciudad")).value = "";
                    (<HTMLInputElement> document.getElementById("poblacion")).value = "";
                    (<HTMLInputElement> document.getElementById("foto")).value = "";
                    (<HTMLInputElement> document.getElementById("cboPais")).value = "1";
                    (<HTMLInputElement>document.getElementById("imgFoto")).src="ciudad_default.jpg";

                }
            
        }
        ,form);
        }

        public static MostrarCiudadBorradas()
        {
           /* let ajax =new Ajax();
        ajax.Get("./backend/ListadoRecetas.php",(param:any)=>{
           let mostrar=param;
           
           (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
         }           
        )*/
        let nombre="";
        let ajax =new Ajax();
        ajax.Get("./BACKEND/EliminarCiudad.php",(param:any)=>{
           let mostrar="<table><tr><th>ID</th><th>NOMBRE</th><th>POBLACION.B</th><th>PAIS</th><th>FOTO</th><th>ACCIONES</th></tr>";
           let listo=JSON.parse(param);
           let lista=listo.dato;
           // let hola=param.dato;
           // let lista=JSON.parse(hola);
           for(let i=0; i<lista.length;i++)
           {
            mostrar+='<tr><td>';
            mostrar+=lista[i].id;
            mostrar+='</td><td>';
            mostrar+=lista[i].nombre;
            mostrar+='</td><td>';           
            mostrar+=lista[i].poblacion;
            mostrar+='</td><td>';
            mostrar+=lista[i].pais;
            mostrar+='</td><td>';
           
            if(lista[i].pathFoto!=null)
            {
                mostrar+="<img src='./BACKEND/ciudadesBorradas/" + lista[i].pathFoto + "' width='85' height='85'>";
  
            }

           /* mostrar+='</td>';
            mostrar+="<td><input type='button' value='Borrar' class='btn btn-dark' onclick='RecuperatorioPrimerParcial.Manejadora.EliminarCiudad("+JSON.stringify(lista[i])+")' />";//hace un json
            mostrar+="<input type='button' value='Modificar' class='btn btn-danger' onclick='RecuperatorioPrimerParcial.Manejadora.ModificarCiudad("+JSON.stringify(lista[i])+")' /></td>";//parse->objeto
            mostrar+='</td></tr>';*/
           }
           mostrar+="</table>";
           (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
         }           
        ,nombre)
        }

        public static MostrarCiudadModificada()
        {
           /* let ajax =new Ajax();
        ajax.Get("./backend/ListadoRecetas.php",(param:any)=>{
           let mostrar=param;
           
           (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
         }           
        )*/
        let nombre="";
        let ajax =new Ajax();
        ajax.Get("./BACKEND/ModificarCiudad.php",(param:any)=>{
           let mostrar="<table><tr><th>ID</th><th>NOMBRE</th><th>POBLACION.B</th><th>PAIS</th><th>FOTO</th><th>ACCIONES</th></tr>";
           let listo=JSON.parse(param);
           let lista=listo.dato;
           // let hola=param.dato;
           // let lista=JSON.parse(hola);
           for(let i=0; i<lista.length;i++)
           {
            mostrar+='<tr><td>';
            mostrar+=lista[i].id;
            mostrar+='</td><td>';
            mostrar+=lista[i].nombre;
            mostrar+='</td><td>';           
            mostrar+=lista[i].poblacion;
            mostrar+='</td><td>';
            mostrar+=lista[i].pais;
            mostrar+='</td><td>';
           
            if(lista[i].pathFoto!=null)
            {
                mostrar+="<img src='./BACKEND/ciudadesModificadas/" + lista[i].pathFoto + "' width='85' height='85'>";
  
            }

          /*  mostrar+='</td>';
            mostrar+="<td><input type='button' value='Borrar' class='btn btn-dark' onclick='RecuperatorioPrimerParcial.Manejadora.EliminarCiudad("+JSON.stringify(lista[i])+")' />";//hace un json
            mostrar+="<input type='button' value='Modificar' class='btn btn-danger' onclick='RecuperatorioPrimerParcial.Manejadora.ModificarCiudad("+JSON.stringify(lista[i])+")' /></td>";//parse->objeto
            mostrar+='</td></tr>';*/
           }
           mostrar+="</table>";
           (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
         }           
        ,nombre)
        }
    }
}
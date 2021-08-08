/// <reference path="./empleado.ts" /> 
/// <reference path="./ajax.ts" /> 

namespace ModeloParcial{
    export class ManejadoraEmpleados{

        public static AgregarEmpleado()
        {
            let nombre = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave = (<HTMLInputElement> document.getElementById("clave")).value;
            let id_perfil = (<HTMLInputElement> document.getElementById("cboPerfiles")).value;
            let sueldo = (<HTMLInputElement> document.getElementById("sueldo")).value;
            let foto = (<HTMLInputElement> document.getElementById("foto")).files;

            if(foto?.length != undefined && foto?.length > 0)
            {
                let form = new FormData();
                form.append("nombre", nombre);
                form.append("correo", correo);
                form.append("clave", clave);
                form.append("id_perfil", id_perfil);
                form.append("foto", foto[0]);
                form.append("sueldo", sueldo);

                let ajax = new Ajax();
                ajax.Post("./backend/AltaEmpleado.php", 
                (param : any)=>{
                    alert(JSON.parse(param).mensaje);
                    console.log(JSON.parse(param).mensaje);
                    ManejadoraEmpleados.MostrarEmpleados();

                    (<HTMLInputElement> document.getElementById("nombre")).value = "";
                    (<HTMLInputElement> document.getElementById("correo")).value = "";
                    (<HTMLInputElement> document.getElementById("clave")).value = "";
                    (<HTMLInputElement> document.getElementById("cboPerfiles")).value = "1";
                    (<HTMLInputElement> document.getElementById("sueldo")).value = "";
                    (<HTMLInputElement> document.getElementById("foto")).value = "";

                }, form)
            }
            else{
                alert("No se selecciono foto");
                console.log("No se selecciono foto");
            }
        }

        public static MostrarEmpleados()
        {
            let ajax = new Ajax();
            ajax.Get("./backend/ListadoEmpleados.php", 
            (param : any)=>{
                let usuario_json = JSON.parse(param);
                let tabla = "<table border=1>";
                tabla += "<thead>";
                tabla += "<tr>";
                tabla += "<td>Id</td>";
                tabla += "<td>Nombre</td>";
                tabla += "<td>Correo</td>";
                tabla += "<td>id_Perfil</td>";
                tabla += "<td>Perfil</td>";
                tabla += "<td>Acciones</td>";
                tabla += "</tr>";
                tabla += "</thead>";
                tabla += "<tbody>";

                for (let i=0; i<usuario_json.length;i++) {
                    let empleado = new Entidades.Empleado(usuario_json[i].nombre, usuario_json[i].correo, usuario_json[i].clave, usuario_json[i].id, usuario_json[i].id_perfil, usuario_json[i].perfil, usuario_json[i].sueldo, usuario_json[i].foto);
                    tabla+='<tr><td>';
                    tabla+=empleado.id;
                    tabla+='</td><td>';
                    tabla+=empleado.nombre;
                    tabla+='</td><td>';
                    tabla+=empleado.correo;
                    tabla+='</td><td>';
                    tabla+=empleado.id_perfil;
                    tabla+='</td><td>';
                    tabla+=empleado.perfil;
                    tabla+='</td><td>';
                    tabla+=empleado.sueldo;
                    tabla+='</td><td>';
                    tabla+="<img src='"+empleado.foto+"' height=50 width=50 />"
                    tabla+='</td>';
                    tabla+="<td><input type='button' value='Borrar' class='btn btn-dark' onclick='ModeloParcial.ManejadoraEmpleados.EliminarEmpleado("+JSON.stringify(empleado)+")' />";
                    tabla+="<input type='button' value='Modificar' class='btn btn-danger' onclick='ModeloParcial.ManejadoraEmpleados.ModificarEmpleado("+JSON.stringify(empleado)+")' /></td>";
                    tabla+='</td></tr>';
                }
                
                tabla += "</tbody>"
                tabla += "</table>";

                (<HTMLDivElement> document.getElementById("divTablaEmpleados")).innerHTML = tabla;
            })
        }

        public static ModificarEmpleado(empleado : any)
        {
            (<HTMLInputElement> document.getElementById("id")).value = empleado.id;
            (<HTMLInputElement> document.getElementById("nombre")).value = empleado.nombre;
            (<HTMLInputElement> document.getElementById("correo")).value = empleado.correo;
            (<HTMLInputElement> document.getElementById("clave")).value = empleado.clave;
            (<HTMLInputElement> document.getElementById("cboPerfiles")).value = empleado.id_perfil;
            (<HTMLInputElement> document.getElementById("sueldo")).value = empleado.sueldo;

            if(empleado.foto != null)
            {
              (<HTMLImageElement> document.getElementById("imgFoto")).src = empleado.foto;  
            }
            
        }

        public static Modificar()
        {
            let id = (<HTMLInputElement> document.getElementById("id")).value;
            let nombre = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave = (<HTMLInputElement> document.getElementById("clave")).value;
            let id_perfil = (<HTMLInputElement> document.getElementById("cboPerfiles")).value;
            let sueldo = (<HTMLInputElement> document.getElementById("sueldo")).value;
            let foto = (<HTMLInputElement> document.getElementById("foto")).files;

            if(foto?.length != undefined && foto?.length > 0)
            {
                let form = new FormData();
                let empleado = new Entidades.Empleado(nombre, correo, clave, parseInt(id), parseInt(id_perfil), "", parseInt(sueldo), "");
                form.append("empleado_json", empleado.ToString());
                form.append("foto", foto[0]);

                let ajax = new Ajax();
                ajax.Post("./backend/ModificarEmpleado.php", 
                (param : any)=>{
                    alert(JSON.parse(param).mensaje);
                    console.log(JSON.parse(param).mensaje);
                    if(JSON.parse(param).exito)
                    {
                      ManejadoraEmpleados.MostrarEmpleados();

                    (<HTMLInputElement> document.getElementById("nombre")).value = "";
                    (<HTMLInputElement> document.getElementById("correo")).value = "";
                    (<HTMLInputElement> document.getElementById("clave")).value = "";
                    (<HTMLInputElement> document.getElementById("cboPerfiles")).value = "1";
                    (<HTMLInputElement> document.getElementById("sueldo")).value = "";
                    (<HTMLInputElement> document.getElementById("foto")).value = "";  
                    }

                }, form)
            }
            else{
                alert("No se selecciono foto");
                console.log("No se selecciono foto");
            }
        }

        public static EliminarEmpleado(empleado : any)
        {
            if(!confirm("Desea eliminar al usuatio seleccionado? nombre: "+empleado.nombre+" correo: "+empleado.correo))
            return;

            let ajax = new Ajax();
            let form = new FormData();
            form.append("id", empleado.id);
            ajax.Post("./backend/EliminarEmpleado.php",
                (param : any)=>{
                    alert(JSON.parse(param).mensaje);
                    console.log(JSON.parse(param).mensaje);

                    if(JSON.parse(param).exito)
                    {
                        ManejadoraEmpleados.MostrarEmpleados();
                    }
                }, form);
        }
    }
}
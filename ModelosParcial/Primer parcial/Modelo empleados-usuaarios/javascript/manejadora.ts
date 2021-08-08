/// <reference path="./empleado.ts" /> 
/// <reference path="./ajax.ts" /> 

namespace ModeloParcial{

    export class Manejadora{
        public static AgregarUsuarioJSON()
        {
            let nombre : string = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo : string = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave : string = (<HTMLInputElement> document.getElementById("clave")).value;

            let form = new FormData();
            form.append("nombre", nombre);
            form.append("correo", correo);
            form.append("clave", clave);

            let ajax = new Ajax();
            ajax.Post("./backend/AltaUsuarioJSON.php", (param : any)=>{alert(param); console.log(param);}
                        , form);
        }

        public static MostrarUsuariosJSON()
        {
            let ajax = new Ajax();
            ajax.Get("./backend/ListadoUsuariosJSON.php", 
            (param : any)=>{
                if(param == "No se recibio GET")
                {
                    alert(param);
                    console.log(param);
                }
                else{
                    let tabla ="<table width=100% border = '2'><tr><td>Nombre</td><td>Correo</td><td>Clave</td></tr>";
                    let lista = JSON.parse(param);

                    for (let i=0; i<lista.length;i++) {
                        tabla+='<tr><td>';
                        tabla+=lista[i].nombre;
                        tabla+='</td><td>';
                        tabla+=lista[i].correo;
                        tabla+='</td><td>';
                        tabla+=lista[i].clave;
                        tabla+='</td></tr>';
                    }
                    (<HTMLDivElement> document.getElementById("divTabla")).innerHTML = tabla;
                }
            });
        }

        public static AgregarUsuario()
        {
            let nombre = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave = (<HTMLInputElement> document.getElementById("clave")).value;
            let id_perfil = (<HTMLInputElement> document.getElementById("cboPerfiles")).value;

            let form = new FormData();
            form.append("nombre", nombre);
            form.append("correo", correo);
            form.append("clave", clave);
            form.append("id_perfil", id_perfil);

            let ajax = new Ajax();
            ajax.Post("./backend/AltaUsuario.php", 
            (param : any)=>{
                alert(JSON.parse(param).mensaje);
                console.log(JSON.parse(param).mensaje);
            }, form);
        }

        public static VerificarUsuario()
        {
            let correo = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave = (<HTMLInputElement> document.getElementById("clave")).value;

            let usuario_json = JSON.stringify(new Entidades.Usuario("", correo, clave));

            let form = new FormData();
            form.append("usuario_json", usuario_json);

            let ajax = new Ajax();
            ajax.Post("./backend/VerificarUsuario.php",
                (param : any)=>{
                    alert(JSON.parse(param).mensaje);
                    console.log(JSON.parse(param).mensaje);
                }, form);
        }

        public static MostrarUsuarios()
        {
            let ajax = new Ajax();
            ajax.Get("./backend/ListadoUsuarios.php", 
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
                    let usuario = new Entidades.Usuario(usuario_json[i].nombre, usuario_json[i].correo, usuario_json[i].clave,usuario_json[i].id, usuario_json[i].id_perfil, usuario_json[i].perfil);
                    tabla+='<tr><td>';
                    tabla+=usuario.id;
                    tabla+='</td><td>';
                    tabla+=usuario.nombre;
                    tabla+='</td><td>';
                    tabla+=usuario.correo;
                    tabla+='</td><td>';
                    tabla+=usuario.id_perfil;
                    tabla+='</td><td>';
                    tabla+=usuario.perfil;
                    tabla+='</td>';
                    tabla+="<td><input type='button' value='Borrar' class='btn btn-dark' onclick='ModeloParcial.Manejadora.EliminarUsuario("+JSON.stringify(usuario)+")' />";
                    tabla+="<input type='button' value='Modificar' class='btn btn-danger' onclick='ModeloParcial.Manejadora.ModificarUsuario("+JSON.stringify(usuario)+")' /></td>";
                    tabla+='</td></tr>';
                }
                
                tabla += "</tbody>"
                tabla += "</table>";

                (<HTMLDivElement> document.getElementById("divTabla")).innerHTML = tabla;
            })
        }

        public static ModificarUsuario(usuario : any)
        {
            (<HTMLInputElement> document.getElementById("id")).value = usuario.id;
            (<HTMLInputElement> document.getElementById("nombre")).value = usuario.nombre;
            (<HTMLInputElement> document.getElementById("correo")).value = usuario.correo;
            (<HTMLInputElement> document.getElementById("clave")).value = usuario.Clave;
            (<HTMLInputElement> document.getElementById("cboPerfiles")).value = usuario.id_perfil;
        }

        public static Modificar()
        {
            let id = (<HTMLInputElement> document.getElementById("id")).value;
            let nombre = (<HTMLInputElement> document.getElementById("nombre")).value;
            let correo = (<HTMLInputElement> document.getElementById("correo")).value;
            let clave = (<HTMLInputElement> document.getElementById("clave")).value;
            let id_perfil = (<HTMLInputElement> document.getElementById("cboPerfiles")).value;

            let form = new FormData();
            let usuario = new Entidades.Usuario(nombre, correo, clave, parseInt(id), parseInt(id_perfil));
            form.append("usuario_json", usuario.ToString());

            let ajax = new Ajax();
            ajax.Post("./backend/ModificarUsuario.php", 
            (param : any)=>{
                let aux = JSON.parse(param);
                if(aux.exito == true)
                {
                    alert(aux.mensaje);
                    console.log(aux.mensaje);
                    Manejadora.MostrarUsuarios();
                    (<HTMLInputElement> document.getElementById("id")).value = "";
                    (<HTMLInputElement> document.getElementById("nombre")).value = "";
                    (<HTMLInputElement> document.getElementById("correo")).value = "";
                    (<HTMLInputElement> document.getElementById("clave")).value = "";
                    (<HTMLInputElement> document.getElementById("cboPerfiles")).value = "1";
                }
                else{
                    alert(aux.mensaje);
                    console.log(aux.mensaje);
                }
                
            }, form);
        }

        public static EliminarUsuario(usuario : any)
        {
            if(!confirm("Desea eliminar al usuatio seleccionado? nombre: "+usuario.nombre+" correo: "+usuario.correo))
            return;

            let ajax = new Ajax();
            let form = new FormData();
            form.append("id", usuario.id);
            form.append("accion", "borrar");
            ajax.Post("./backend/EliminarUsuario.php",
                (param : any)=>{
                    alert(JSON.parse(param).mensaje);
                    console.log(JSON.parse(param).mensaje);

                    if(JSON.parse(param).exito)
                    {
                        Manejadora.MostrarUsuarios();
                    }
                }, form);
        }
    }
}
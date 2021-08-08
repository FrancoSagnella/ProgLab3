var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Entidades;
(function (Entidades) {
    var Persona = /** @class */ (function () {
        function Persona(nombre, correo, clave) {
            this.nombre = nombre;
            this.correo = correo;
            this.clave = clave;
        }
        Persona.prototype.ToString = function () {
            return JSON.stringify(this);
        };
        Persona.prototype.ToJSON = function () {
            return JSON.parse(this.ToString());
        };
        return Persona;
    }());
    Entidades.Persona = Persona;
})(Entidades || (Entidades = {}));
/// <reference path="./persona.ts" /> 
var Entidades;
(function (Entidades) {
    var Usuario = /** @class */ (function (_super) {
        __extends(Usuario, _super);
        function Usuario(nombre, correo, clave, id, id_perfil, perfil) {
            if (nombre === void 0) { nombre = ""; }
            if (id === void 0) { id = 0; }
            if (id_perfil === void 0) { id_perfil = 0; }
            if (perfil === void 0) { perfil = ""; }
            var _this = 
            //llamo al constructor padre
            _super.call(this, nombre, correo, clave) || this;
            _this.id = id;
            _this.id_perfil = id_perfil;
            _this.perfil = perfil;
            return _this;
        }
        Usuario.prototype.ToString = function () {
            return JSON.stringify(this);
        };
        Usuario.prototype.ToJSON = function () {
            return JSON.parse(this.ToString());
        };
        return Usuario;
    }(Entidades.Persona));
    Entidades.Usuario = Usuario;
})(Entidades || (Entidades = {}));
/// <reference path="./usuario.ts" /> 
var Entidades;
(function (Entidades) {
    var Empleado = /** @class */ (function (_super) {
        __extends(Empleado, _super);
        function Empleado(nombre, correo, clave, id, id_perfil, perfil, sueldo, foto) {
            var _this = 
            //llamo al constructor padre
            _super.call(this, nombre, correo, clave, id, id_perfil, perfil) || this;
            _this.sueldo = sueldo;
            _this.foto = foto;
            return _this;
        }
        Empleado.prototype.ToString = function () {
            return JSON.stringify(this);
        };
        Empleado.prototype.ToJSON = function () {
            return JSON.parse(this.ToString());
        };
        return Empleado;
    }(Entidades.Usuario));
    Entidades.Empleado = Empleado;
})(Entidades || (Entidades = {}));
var Ajax = /** @class */ (function () {
    function Ajax() {
        var _this = this;
        this.Get = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            var parametros = params.length > 0 ? params : "";
            ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
            _this._xhr.open('GET', ruta);
            _this._xhr.send();
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.status);
                        }
                    }
                }
            };
        };
        this.Post = function (ruta, success, params, error) {
            //let parametros:string = params.length > 0 ? params : "";
            if (params === void 0) { params = ""; }
            _this._xhr.open('POST', ruta, true);
            //this._xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
            _this._xhr.send(params);
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.status);
                        }
                    }
                }
            };
        };
        this._xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }
    return Ajax;
}());
/// <reference path="./empleado.ts" /> 
/// <reference path="./ajax.ts" /> 
var ModeloParcial;
(function (ModeloParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarUsuarioJSON = function () {
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var form = new FormData();
            form.append("nombre", nombre);
            form.append("correo", correo);
            form.append("clave", clave);
            var ajax = new Ajax();
            ajax.Post("./backend/AltaUsuarioJSON.php", function (param) { alert(param); console.log(param); }, form);
        };
        Manejadora.MostrarUsuariosJSON = function () {
            var ajax = new Ajax();
            ajax.Get("./backend/ListadoUsuariosJSON.php", function (param) {
                if (param == "No se recibio GET") {
                    alert(param);
                    console.log(param);
                }
                else {
                    var tabla = "<table width=100% border = '2'><tr><td>Nombre</td><td>Correo</td><td>Clave</td></tr>";
                    var lista = JSON.parse(param);
                    for (var i = 0; i < lista.length; i++) {
                        tabla += '<tr><td>';
                        tabla += lista[i].nombre;
                        tabla += '</td><td>';
                        tabla += lista[i].correo;
                        tabla += '</td><td>';
                        tabla += lista[i].clave;
                        tabla += '</td></tr>';
                    }
                    document.getElementById("divTabla").innerHTML = tabla;
                }
            });
        };
        Manejadora.AgregarUsuario = function () {
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var id_perfil = document.getElementById("cboPerfiles").value;
            var form = new FormData();
            form.append("nombre", nombre);
            form.append("correo", correo);
            form.append("clave", clave);
            form.append("id_perfil", id_perfil);
            var ajax = new Ajax();
            ajax.Post("./backend/AltaUsuario.php", function (param) {
                alert(JSON.parse(param).mensaje);
                console.log(JSON.parse(param).mensaje);
            }, form);
        };
        Manejadora.VerificarUsuario = function () {
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var usuario_json = JSON.stringify(new Entidades.Usuario("", correo, clave));
            var form = new FormData();
            form.append("usuario_json", usuario_json);
            var ajax = new Ajax();
            ajax.Post("./backend/VerificarUsuario.php", function (param) {
                alert(JSON.parse(param).mensaje);
                console.log(JSON.parse(param).mensaje);
            }, form);
        };
        Manejadora.MostrarUsuarios = function () {
            var ajax = new Ajax();
            ajax.Get("./backend/ListadoUsuarios.php", function (param) {
                var usuario_json = JSON.parse(param);
                var tabla = "<table border=1>";
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
                for (var i = 0; i < usuario_json.length; i++) {
                    var usuario = new Entidades.Usuario(usuario_json[i].nombre, usuario_json[i].correo, usuario_json[i].clave, usuario_json[i].id, usuario_json[i].id_perfil, usuario_json[i].perfil);
                    tabla += '<tr><td>';
                    tabla += usuario.id;
                    tabla += '</td><td>';
                    tabla += usuario.nombre;
                    tabla += '</td><td>';
                    tabla += usuario.correo;
                    tabla += '</td><td>';
                    tabla += usuario.id_perfil;
                    tabla += '</td><td>';
                    tabla += usuario.perfil;
                    tabla += '</td>';
                    tabla += "<td><input type='button' value='Borrar' class='btn btn-dark' onclick='ModeloParcial.Manejadora.EliminarUsuario(" + JSON.stringify(usuario) + ")' />";
                    tabla += "<input type='button' value='Modificar' class='btn btn-danger' onclick='ModeloParcial.Manejadora.ModificarUsuario(" + JSON.stringify(usuario) + ")' /></td>";
                    tabla += '</td></tr>';
                }
                tabla += "</tbody>";
                tabla += "</table>";
                document.getElementById("divTabla").innerHTML = tabla;
            });
        };
        Manejadora.ModificarUsuario = function (usuario) {
            document.getElementById("id").value = usuario.id;
            document.getElementById("nombre").value = usuario.nombre;
            document.getElementById("correo").value = usuario.correo;
            document.getElementById("clave").value = usuario.Clave;
            document.getElementById("cboPerfiles").value = usuario.id_perfil;
        };
        Manejadora.Modificar = function () {
            var id = document.getElementById("id").value;
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var id_perfil = document.getElementById("cboPerfiles").value;
            var form = new FormData();
            var usuario = new Entidades.Usuario(nombre, correo, clave, parseInt(id), parseInt(id_perfil));
            form.append("usuario_json", usuario.ToString());
            var ajax = new Ajax();
            ajax.Post("./backend/ModificarUsuario.php", function (param) {
                var aux = JSON.parse(param);
                if (aux.exito == true) {
                    alert(aux.mensaje);
                    console.log(aux.mensaje);
                    Manejadora.MostrarUsuarios();
                    document.getElementById("id").value = "";
                    document.getElementById("nombre").value = "";
                    document.getElementById("correo").value = "";
                    document.getElementById("clave").value = "";
                    document.getElementById("cboPerfiles").value = "1";
                }
                else {
                    alert(aux.mensaje);
                    console.log(aux.mensaje);
                }
            }, form);
        };
        Manejadora.EliminarUsuario = function (usuario) {
            if (!confirm("Desea eliminar al usuatio seleccionado? nombre: " + usuario.nombre + " correo: " + usuario.correo))
                return;
            var ajax = new Ajax();
            var form = new FormData();
            form.append("id", usuario.id);
            form.append("accion", "borrar");
            ajax.Post("./backend/EliminarUsuario.php", function (param) {
                alert(JSON.parse(param).mensaje);
                console.log(JSON.parse(param).mensaje);
                if (JSON.parse(param).exito) {
                    Manejadora.MostrarUsuarios();
                }
            }, form);
        };
        return Manejadora;
    }());
    ModeloParcial.Manejadora = Manejadora;
})(ModeloParcial || (ModeloParcial = {}));

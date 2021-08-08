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
    var ManejadoraEmpleados = /** @class */ (function () {
        function ManejadoraEmpleados() {
        }
        ManejadoraEmpleados.AgregarEmpleado = function () {
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var id_perfil = document.getElementById("cboPerfiles").value;
            var sueldo = document.getElementById("sueldo").value;
            var foto = document.getElementById("foto").files;
            if ((foto === null || foto === void 0 ? void 0 : foto.length) != undefined && (foto === null || foto === void 0 ? void 0 : foto.length) > 0) {
                var form = new FormData();
                form.append("nombre", nombre);
                form.append("correo", correo);
                form.append("clave", clave);
                form.append("id_perfil", id_perfil);
                form.append("foto", foto[0]);
                form.append("sueldo", sueldo);
                var ajax = new Ajax();
                ajax.Post("./backend/AltaEmpleado.php", function (param) {
                    alert(JSON.parse(param).mensaje);
                    console.log(JSON.parse(param).mensaje);
                    ManejadoraEmpleados.MostrarEmpleados();
                    document.getElementById("nombre").value = "";
                    document.getElementById("correo").value = "";
                    document.getElementById("clave").value = "";
                    document.getElementById("cboPerfiles").value = "1";
                    document.getElementById("sueldo").value = "";
                    document.getElementById("foto").value = "";
                }, form);
            }
            else {
                alert("No se selecciono foto");
                console.log("No se selecciono foto");
            }
        };
        ManejadoraEmpleados.MostrarEmpleados = function () {
            var ajax = new Ajax();
            ajax.Get("./backend/ListadoEmpleados.php", function (param) {
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
                    var empleado = new Entidades.Empleado(usuario_json[i].nombre, usuario_json[i].correo, usuario_json[i].clave, usuario_json[i].id, usuario_json[i].id_perfil, usuario_json[i].perfil, usuario_json[i].sueldo, usuario_json[i].foto);
                    tabla += '<tr><td>';
                    tabla += empleado.id;
                    tabla += '</td><td>';
                    tabla += empleado.nombre;
                    tabla += '</td><td>';
                    tabla += empleado.correo;
                    tabla += '</td><td>';
                    tabla += empleado.id_perfil;
                    tabla += '</td><td>';
                    tabla += empleado.perfil;
                    tabla += '</td><td>';
                    tabla += empleado.sueldo;
                    tabla += '</td><td>';
                    tabla += "<img src='" + empleado.foto + "' height=50 width=50 />";
                    tabla += '</td>';
                    tabla += "<td><input type='button' value='Borrar' class='btn btn-dark' onclick='ModeloParcial.ManejadoraEmpleados.EliminarEmpleado(" + JSON.stringify(empleado) + ")' />";
                    tabla += "<input type='button' value='Modificar' class='btn btn-danger' onclick='ModeloParcial.ManejadoraEmpleados.ModificarEmpleado(" + JSON.stringify(empleado) + ")' /></td>";
                    tabla += '</td></tr>';
                }
                tabla += "</tbody>";
                tabla += "</table>";
                document.getElementById("divTablaEmpleados").innerHTML = tabla;
            });
        };
        ManejadoraEmpleados.ModificarEmpleado = function (empleado) {
            document.getElementById("id").value = empleado.id;
            document.getElementById("nombre").value = empleado.nombre;
            document.getElementById("correo").value = empleado.correo;
            document.getElementById("clave").value = empleado.clave;
            document.getElementById("cboPerfiles").value = empleado.id_perfil;
            document.getElementById("sueldo").value = empleado.sueldo;
            if (empleado.foto != null) {
                document.getElementById("imgFoto").src = empleado.foto;
            }
        };
        ManejadoraEmpleados.Modificar = function () {
            var id = document.getElementById("id").value;
            var nombre = document.getElementById("nombre").value;
            var correo = document.getElementById("correo").value;
            var clave = document.getElementById("clave").value;
            var id_perfil = document.getElementById("cboPerfiles").value;
            var sueldo = document.getElementById("sueldo").value;
            var foto = document.getElementById("foto").files;
            if ((foto === null || foto === void 0 ? void 0 : foto.length) != undefined && (foto === null || foto === void 0 ? void 0 : foto.length) > 0) {
                var form = new FormData();
                var empleado = new Entidades.Empleado(nombre, correo, clave, parseInt(id), parseInt(id_perfil), "", parseInt(sueldo), "");
                form.append("empleado_json", empleado.ToString());
                form.append("foto", foto[0]);
                var ajax = new Ajax();
                ajax.Post("./backend/ModificarEmpleado.php", function (param) {
                    alert(JSON.parse(param).mensaje);
                    console.log(JSON.parse(param).mensaje);
                    if (JSON.parse(param).exito) {
                        ManejadoraEmpleados.MostrarEmpleados();
                        document.getElementById("nombre").value = "";
                        document.getElementById("correo").value = "";
                        document.getElementById("clave").value = "";
                        document.getElementById("cboPerfiles").value = "1";
                        document.getElementById("sueldo").value = "";
                        document.getElementById("foto").value = "";
                    }
                }, form);
            }
            else {
                alert("No se selecciono foto");
                console.log("No se selecciono foto");
            }
        };
        ManejadoraEmpleados.EliminarEmpleado = function (empleado) {
            if (!confirm("Desea eliminar al usuatio seleccionado? nombre: " + empleado.nombre + " correo: " + empleado.correo))
                return;
            var ajax = new Ajax();
            var form = new FormData();
            form.append("id", empleado.id);
            form.append("accion", "borrar");
            ajax.Post("./backend/EliminarEmpleado.php", function (param) {
                alert(JSON.parse(param).mensaje);
                    console.log(JSON.parse(param).mensaje);
                if (JSON.parse(param).exito) {
                    ManejadoraEmpleados.MostrarEmpleados();
                }
            }, form);
        };
        return ManejadoraEmpleados;
    }());
    ModeloParcial.ManejadoraEmpleados = ManejadoraEmpleados;
})(ModeloParcial || (ModeloParcial = {}));

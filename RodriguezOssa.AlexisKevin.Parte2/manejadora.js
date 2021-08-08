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
    var Producto = /** @class */ (function () {
        function Producto(nombre, origen) {
            this.nombre = nombre;
            this.origen = origen;
        }
        Producto.prototype.ToString = function () {
            // return `"nombre":"${this.nombe}","origen":"${this.origen}",`
            return JSON.stringify(this);
        };
        Producto.prototype.ToJSon = function () {
            return JSON.parse(this.ToString());
        };
        return Producto;
    }());
    Entidades.Producto = Producto;
})(Entidades || (Entidades = {}));
///<reference path="Producto.ts"/>
var Entidades;
(function (Entidades) {
    var ProductoEnVasado = /** @class */ (function (_super) {
        __extends(ProductoEnVasado, _super);
        function ProductoEnVasado(nombre, origen, id, codigoBarra, precio, pathFoto) {
            var _this = _super.call(this, nombre, origen) || this;
            _this.id = id;
            _this.codigoBarra = codigoBarra;
            _this.precio = precio;
            _this.pathFoto = pathFoto;
            return _this;
        }
        ProductoEnVasado.prototype.ToString = function () {
            // return `"id":"${this.id}","codigoBarra":"${this.codigoBarra}","precio":"${this.precio}","pathFoto":"${this.pathFoto}"`
            return JSON.stringify(this);
        };
        ProductoEnVasado.prototype.ToJSon = function () {
            return JSON.parse(this.ToString());
        };
        return ProductoEnVasado;
    }(Entidades.Producto));
    Entidades.ProductoEnVasado = ProductoEnVasado;
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
            // let parametros:string = params.length > 0 ? params : "";
            if (params === void 0) { params = ""; }
            _this._xhr.open('POST', ruta, true);
            //  this._xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
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
///<reference path="ProductoEnvasado.ts"/>
///<reference path="ajax.ts"/>
var PrimerParcial;
(function (PrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.AgregarProductoJSON = function () {
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var form = new FormData();
            form.append("nombre", nombre);
            form.append("origen", origen);
            var ajax = new Ajax();
            ajax.Post("./backend/AltaProductoJSON.php", function (param) {
                alert(JSON.parse(param).mensaje);
                console.log(JSON.parse(param).mensaje);
            }, form);
        };
        Manejadora.MostrarProductosJSON = function () {
            var ajax = new Ajax();
            ajax.Get("./backend/ListadoProductosJSON.php", function (param) {
                var mostrar = "<table><tr><th>NOMBRE</th><th>ORIGEN</th></tr>";
                var lista = JSON.parse(param);
                for (var i = 0; i < lista.length; i++) {
                    mostrar += '<tr><td>';
                    mostrar += lista[i].nombre;
                    mostrar += '</td><td>';
                    mostrar += lista[i].origen;
                    mostrar += '</td>';
                    mostrar += '</tr>';
                }
                mostrar += "</table>";
                document.getElementById("divTabla").innerHTML = mostrar;
            });
        };
        Manejadora.VerificarProductoJSON = function () {
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            //testear con tojson
            var form = new FormData();
            form.append("origen", origen);
            form.append("nombre", nombre);
            var ajax = new Ajax();
            ajax.Post("./backend/VerificarProductoJSON.php", function (param) {
                //alert("hola");
                alert(JSON.parse(param).mensaje);
                console.log(JSON.parse(param).mensaje);
            }, form);
        };
        Manejadora.MostrarInfoCookie = function () {
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            //testear con tojson
            var ajax = new Ajax();
            ajax.Get("./backend/MostrarCookie.php", function (param) {
                alert(JSON.parse(param).mensaje);
                console.log(JSON.parse(param).mensaje);
            }, "nombre=" + nombre + "&origen=" + origen);
        };
        Manejadora.AgregarProductoSinFoto = function () {
            var nombre = document.getElementById("nombre").value;
            var origen = document.getElementById("cboOrigen").value;
            var codigoBarra = document.getElementById("codigoBarra").value;
            var precio = document.getElementById("precio").value;
            var producto = JSON.stringify(new Entidades.ProductoEnVasado(nombre, origen, 0, parseInt(codigoBarra), parseInt(precio), "")); //lo hago tipo json
            var form = new FormData();
            form.append("producto_json", producto);
            var ajax = new Ajax();
            ajax.Post("./backend/AgregarProductoSinFoto.php", function (param) {
                //(<HTMLInputElement> document.getElementById("id")).value = "";
                document.getElementById("nombre").value = "";
                document.getElementById("precio").value = "";
                document.getElementById("codigoBarra").value = "";
                document.getElementById("cboOrigen").value = "1";
                alert(JSON.parse(param).mensaje);
                console.log(param);
            }, form);
        };
        Manejadora.MostrarProductosEnvasados = function () {
            var ajax = new Ajax();
            ajax.Get("./backend/ListadoProductosEnvasados.php", function (param) {
                var mostrar = "<table><tr><th>ID</th><th>NOMBRE</th><th>CODIGO.B</th><th>ORIGEN</th><th>PRECIO</th><th>ACCIONES</th></tr>";
                var lista = JSON.parse(param);
                for (var i = 0; i < lista.length; i++) {
                    mostrar += '<tr><td>';
                    mostrar += lista[i].id;
                    mostrar += '</td><td>';
                    mostrar += lista[i].nombre;
                    mostrar += '</td><td>';
                    mostrar += lista[i].codigoBarra;
                    mostrar += '</td><td>';
                    mostrar += lista[i].origen;
                    mostrar += '</td><td>';
                    mostrar += lista[i].precio;
                    mostrar += '</td>';
                    mostrar += "<td><input type='button' value='Borrar' class='btn btn-dark' onclick='ModeloParcial.Manejadora.EliminarUsuario(" + JSON.stringify(lista[i]) + ")' />";
                    mostrar += "<input type='button' value='Modificar' class='btn btn-danger' onclick='ModeloParcial.Manejadora.ModificarUsuario(" + JSON.stringify(lista[i]) + ")' /></td>";
                    mostrar += '</td></tr>';
                }
                mostrar += "</table>";
                document.getElementById("divTabla").innerHTML = mostrar;
            });
        };
        return Manejadora;
    }());
    PrimerParcial.Manejadora = Manejadora;
})(PrimerParcial || (PrimerParcial = {}));

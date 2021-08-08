var Entidades;
(function (Entidades) {
    var Ciudad = /** @class */ (function () {
        //foto : string;
        function Ciudad(id, nombre, poblacion, pais) {
            this.id = id;
            this.nombre = nombre;
            this.poblacion = poblacion;
            this.pais = pais;
        }
        Ciudad.prototype.ToJSON = function () {
            var retornoJSON = "{\"id\":\"" + this.id + "\",\"nombre\":" + this.nombre + ",\"poblacion\":\"" + this.poblacion + "\",\"pais\":" + this.pais + "\"} ";
            return JSON.parse(retornoJSON);
        };
        return Ciudad;
    }());
    Entidades.Ciudad = Ciudad;
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
/// <reference path="ciudad.ts"/>
///<reference path="ajax.ts"/>
/// <reference path="./node_modules/@types/jquery/index.d.ts" />
var RecuperatorioPrimerParcial;
(function (RecuperatorioPrimerParcial) {
    var Manejadora = /** @class */ (function () {
        function Manejadora() {
        }
        Manejadora.VisualizarFoto = function () {
            //if($("#foto").val() === "")
            if (document.getElementById("foto").value === "") {
                //  $("#imgFoto").attr("src", "default-avatar.png");
                document.getElementById("imgFoto").src = "ciudad_default.jpg";
                return;
            }
            var foto = document.getElementById("foto").files;
            var reader = new FileReader();
            reader.readAsDataURL(foto[0]);
            reader.onload = function () {
                //  $("#imgFoto").attr("src", <string> reader.result);
                document.getElementById("imgFoto").src = reader.result;
            };
        };
        Manejadora.AgregarCiudad = function () {
            var nombre = document.getElementById("nombre").value;
            var poblacion = document.getElementById("poblacion").value;
            var pais = document.getElementById("cboPais").value;
            var foto = document.getElementById("foto");
            var form = new FormData();
            var pob = parseInt(poblacion);
            form.append("nombre", nombre);
            form.append("poblacion", poblacion);
            form.append("pais", pais);
            form.append("foto", foto.files[0]);
            var ajax = new Ajax();
            ajax.Post("./BACKEND/AgregarCiudad.php", function (param) {
                param = JSON.parse(param);
                alert(param.mensaje);
                console.log(param.mensaje);
                if (param.exito) {
                    Manejadora.MostrarCiudad();
                    document.getElementById("nombre").value = "";
                    document.getElementById("poblacion").value = "";
                    document.getElementById("foto").value = "";
                    document.getElementById("cboPais").value = "1";
                    document.getElementById("imgFoto").src = "ciudad_default.jpg";
                }
            }, form);
        };
        Manejadora.MostrarCiudad = function () {
            /* let ajax =new Ajax();
         ajax.Get("./backend/ListadoRecetas.php",(param:any)=>{
            let mostrar=param;
            
            (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
          }
         )*/
            var nombre = "dato=json";
            var ajax = new Ajax();
            ajax.Get("./BACKEND/ListadoCiudades.php", function (param) {
                var mostrar = "<table><tr><th>ID</th><th>NOMBRE</th><th>POBLACION.B</th><th>PAIS</th><th>FOTO</th><th>ACCIONES</th></tr>";
                var listo = JSON.parse(param);
                var lista = listo.dato;
                // let hola=param.dato;
                // let lista=JSON.parse(hola);
                for (var i = 0; i < lista.length; i++) {
                    mostrar += '<tr><td>';
                    mostrar += lista[i].id;
                    mostrar += '</td><td>';
                    mostrar += lista[i].nombre;
                    mostrar += '</td><td>';
                    mostrar += lista[i].poblacion;
                    mostrar += '</td><td>';
                    mostrar += lista[i].pais;
                    mostrar += '</td><td>';
                    if (lista[i].pathFoto != null) {
                        mostrar += "<img src='./BACKEND/ciudades/imagenes/" + lista[i].pathFoto + "' width='85' height='85'>";
                    }
                    mostrar += '</td>';
                    mostrar += "<td><input type='button' value='Borrar' class='btn btn-dark' onclick='RecuperatorioPrimerParcial.Manejadora.EliminarCiudad(" + JSON.stringify(lista[i]) + ")' />"; //hace un json
                    mostrar += "<input type='button' value='Modificar' class='btn btn-danger' onclick='RecuperatorioPrimerParcial.Manejadora.ModificarCiudad(" + JSON.stringify(lista[i]) + ")' /></td>"; //parse->objeto
                    mostrar += '</td></tr>';
                }
                mostrar += "</table>";
                document.getElementById("divTabla").innerHTML = mostrar;
            }, nombre);
        };
        Manejadora.EliminarCiudad = function (ciudad_json) {
            if (!confirm("Desea eliminar la ciudad seleccionado? nombre: " + ciudad_json.nombre + " pais: " + ciudad_json.pais))
                return;
            var ciudad = JSON.stringify(ciudad_json);
            // let producto=producto_json;
            var borrar = "borrar";
            var ajax = new Ajax();
            var form = new FormData();
            form.append("ciudad_json", ciudad);
            // form.append("accion", borrar);
            ajax.Post('./BACKEND/EliminarCiudad.php', function (param) {
                param = JSON.parse(param);
                alert(param.mensaje);
                console.log(param.mensaje);
                if (param.exito == true) {
                    Manejadora.MostrarCiudad();
                }
            }, form);
        };
        Manejadora.ModificarCiudad = function (ciudad_json) {
            document.getElementById("id_ciudad").value = ciudad_json.id;
            document.getElementById("poblacion").value = ciudad_json.poblacion;
            document.getElementById("nombre").value = ciudad_json.nombre;
            //(<HTMLInputElement> document.getElementById("foto")).value = producto_json.pathFoto;
            document.getElementById("cboPais").value = ciudad_json.pais;
            document.getElementById("imgFoto").src = "./BACKEND/ciudades/imagenes/" + ciudad_json.pathFoto;
            document.getElementById("imgFoto").src = "ciudad_default.jpg";
        };
        Manejadora.Modificar = function () {
            var id = document.getElementById("id_ciudad").value;
            var nombre = document.getElementById("nombre").value;
            var poblacion = document.getElementById("poblacion").value;
            var pais = document.getElementById("cboPais").value;
            var foto = document.getElementById("foto");
            // let foto:string=(<HTMLInputElement> document.getElementById("precio")).value;
            var ciudad = JSON.stringify(new Entidades.Ciudad(parseInt(id), nombre, parseInt(poblacion), pais)); //lo hago tipo json
            var form = new FormData();
            form.append("ciudad_json", ciudad);
            form.append("foto", foto.files[0]);
            var ajax = new Ajax();
            ajax.Post("./BACKEND/ModificarCiudad.php", function (param) {
                param = JSON.parse(param);
                alert(param.mensaje);
                console.log(param.mensaje);
                if (param.exito == true) {
                    Manejadora.MostrarCiudad();
                    document.getElementById("nombre").value = "";
                    document.getElementById("id_ciudad").value = "";
                    document.getElementById("poblacion").value = "";
                    document.getElementById("foto").value = "";
                    document.getElementById("cboPais").value = "1";
                    document.getElementById("imgFoto").src = "ciudad_default.jpg";
                }
            }, form);
        };
        Manejadora.MostrarCiudadBorradas = function () {
            /* let ajax =new Ajax();
         ajax.Get("./backend/ListadoRecetas.php",(param:any)=>{
            let mostrar=param;
            
            (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
          }
         )*/
            var nombre = "";
            var ajax = new Ajax();
            ajax.Get("./BACKEND/EliminarCiudad.php", function (param) {
                var mostrar = "<table><tr><th>ID</th><th>NOMBRE</th><th>POBLACION.B</th><th>PAIS</th><th>FOTO</th><th>ACCIONES</th></tr>";
                var listo = JSON.parse(param);
                var lista = listo.dato;
                // let hola=param.dato;
                // let lista=JSON.parse(hola);
                for (var i = 0; i < lista.length; i++) {
                    mostrar += '<tr><td>';
                    mostrar += lista[i].id;
                    mostrar += '</td><td>';
                    mostrar += lista[i].nombre;
                    mostrar += '</td><td>';
                    mostrar += lista[i].poblacion;
                    mostrar += '</td><td>';
                    mostrar += lista[i].pais;
                    mostrar += '</td><td>';
                    if (lista[i].pathFoto != null) {
                        mostrar += "<img src='./BACKEND/ciudadesBorradas/" + lista[i].pathFoto + "' width='85' height='85'>";
                    }
                    /* mostrar+='</td>';
                     mostrar+="<td><input type='button' value='Borrar' class='btn btn-dark' onclick='RecuperatorioPrimerParcial.Manejadora.EliminarCiudad("+JSON.stringify(lista[i])+")' />";//hace un json
                     mostrar+="<input type='button' value='Modificar' class='btn btn-danger' onclick='RecuperatorioPrimerParcial.Manejadora.ModificarCiudad("+JSON.stringify(lista[i])+")' /></td>";//parse->objeto
                     mostrar+='</td></tr>';*/
                }
                mostrar += "</table>";
                document.getElementById("divTabla").innerHTML = mostrar;
            }, nombre);
        };
        Manejadora.MostrarCiudadModificada = function () {
            /* let ajax =new Ajax();
         ajax.Get("./backend/ListadoRecetas.php",(param:any)=>{
            let mostrar=param;
            
            (<HTMLDivElement>document.getElementById("divTabla")).innerHTML = mostrar;
          }
         )*/
            var nombre = "";
            var ajax = new Ajax();
            ajax.Get("./BACKEND/ModificarCiudad.php", function (param) {
                var mostrar = "<table><tr><th>ID</th><th>NOMBRE</th><th>POBLACION.B</th><th>PAIS</th><th>FOTO</th><th>ACCIONES</th></tr>";
                var listo = JSON.parse(param);
                var lista = listo.dato;
                // let hola=param.dato;
                // let lista=JSON.parse(hola);
                for (var i = 0; i < lista.length; i++) {
                    mostrar += '<tr><td>';
                    mostrar += lista[i].id;
                    mostrar += '</td><td>';
                    mostrar += lista[i].nombre;
                    mostrar += '</td><td>';
                    mostrar += lista[i].poblacion;
                    mostrar += '</td><td>';
                    mostrar += lista[i].pais;
                    mostrar += '</td><td>';
                    if (lista[i].pathFoto != null) {
                        mostrar += "<img src='./BACKEND/ciudadesModificadas/" + lista[i].pathFoto + "' width='85' height='85'>";
                    }
                    /*  mostrar+='</td>';
                      mostrar+="<td><input type='button' value='Borrar' class='btn btn-dark' onclick='RecuperatorioPrimerParcial.Manejadora.EliminarCiudad("+JSON.stringify(lista[i])+")' />";//hace un json
                      mostrar+="<input type='button' value='Modificar' class='btn btn-danger' onclick='RecuperatorioPrimerParcial.Manejadora.ModificarCiudad("+JSON.stringify(lista[i])+")' /></td>";//parse->objeto
                      mostrar+='</td></tr>';*/
                }
                mostrar += "</table>";
                document.getElementById("divTabla").innerHTML = mostrar;
            }, nombre);
        };
        return Manejadora;
    }());
    RecuperatorioPrimerParcial.Manejadora = Manejadora;
})(RecuperatorioPrimerParcial || (RecuperatorioPrimerParcial = {}));

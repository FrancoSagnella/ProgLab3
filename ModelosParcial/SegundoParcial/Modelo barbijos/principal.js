"use strict";
/// <reference path="./node_modules/@types/jquery/index.d.ts" />
$(document).ready(function () {
    VerificarToken();
});
function VerificarToken() {
    var token = localStorage.getItem('token');
    if (token == null) {
        window.location.replace("./login.html");
    }
    var xhr = new XMLHttpRequest();
    xhr.open('GET', './BACKEND/login/');
    xhr.setRequestHeader('token', token);
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var respuesta = xhr.responseText;
            var objRespuesta = JSON.parse(respuesta);
            if (!objRespuesta.exito == true) {
                window.location.replace("./login.html");
            }
        }
        else if (xhr.readyState == 4 && xhr.status != 200) {
            window.location.replace("./login.html");
        }
    };
}
function ObtenerListadoUsuarios() {
    VerificarToken();
    var tabla = "";
    var xhr = new XMLHttpRequest();
    //let token : any = localStorage.getItem('token');
    xhr.open('GET', './BACKEND/');
    //xhr.setRequestHeader('jwt', token);
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = JSON.parse(xhr.responseText);
            tabla = ArmarTablaUsuarios(obj.tabla);
            document.getElementById("divUsuarios").innerHTML = "";
            document.getElementById("divUsuarios").innerHTML = tabla;
        }
    };
}
function ObtenerListadoBarbijos() {
    VerificarToken();
    var tabla = "";
    var xhr = new XMLHttpRequest();
    var token = localStorage.getItem('token');
    xhr.open('GET', './BACKEND/barbijos/');
    xhr.setRequestHeader('token', token);
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = JSON.parse(xhr.responseText);
            //console.log(obj);
            tabla = ArmarTablaBarbijos(obj.tabla);
            document.getElementById("divBarbijos").innerHTML = '';
            document.getElementById("divBarbijos").innerHTML = tabla;
        }
    };
}
function ArmarTablaUsuarios(usuarios) {
    var tabla = '<table class="table ">';
    tabla += '<tr><th>Correo</th><th>Nombre</th><th>Apellido</th><th>Perfil</th><th>Foto</th></tr>';
    if (usuarios === false) {
        tabla = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><th>---</td></tr>';
        $('#error').removeClass("hide");
        var aux = void 0;
        aux = document.getElementById("error");
        if (aux != null)
            aux.innerHTML = "No se puedo acceder a la tabla de usuarios!";
    }
    else {
        //usuarios=JSON.parse(usuarios);
        usuarios.forEach(function (cd) {
            tabla += "<tr><td>" + cd.correo + "</td><td>" + cd.nombre + "</td><td>" + cd.apellido + "</td><td>" + cd.perfil + "</td>" +
                "<td>" + "<img style='width: 50px; height: 50px;' src=./BACKEND/fotos/" + cd.foto + ">" +
                "</td></tr>";
        });
    }
    tabla += "</table>";
    return tabla;
}
function ArmarTablaBarbijos(barbijos) {
    var tabla = '<table class="table ">';
    tabla += '<tr><th>Color</th><th>Tipo</th><th>Precio</th><th>Acciones</th></tr>';
    if (barbijos === false) {
        tabla += '<tr><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
        $('#error').removeClass("hide");
        var aux = void 0;
        aux = document.getElementById("error");
        if (aux != null)
            aux.innerHTML = "No se puedo acceder a la tabla de barbijos!";
    }
    else {
        //barbijos=JSON.parse(autos);
        barbijos.forEach(function (cd) {
            tabla += "<tr><td>" + cd.color + "</td><td>" + cd.tipo + "</td><td>" + cd.precio + "</td>" +
                "<td>" + "<button class='btn btn-danger' onclick=" + 'EliminarBarbijo(' + cd.id + ')' + ">Borrar</button>" + "<button class='btn btn-info' onclick=" + 'ModificarBarbijo(' + JSON.stringify(cd) + ')' + '>Modificar</button>' + "</td></tr>";
        });
    }
    tabla += "</table>";
    return tabla;
}
function EliminarBarbijo(id) {
    VerificarToken();
    var jwt = localStorage.getItem('token');
    if (confirm("Esta seguro que quiere eliminar este barbijo?")) {
        $.ajax({
            type: 'DELETE',
            url: "./BACKEND/",
            dataType: "json",
            data: { "id_barbijo": id },
            headers: { "token": jwt },
            async: true
        })
            .done(function (resultado) {
            if (resultado.exito) {
                ObtenerListadoBarbijos();
            }
            else {
                $('#errorLogin').removeClass("hide");
                var aux = void 0;
                aux = document.getElementById("errorLogin");
                if (aux != null)
                    aux.innerHTML = resultado.mensaje + '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            }
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            var retorno = JSON.parse(jqXHR.responseText);
            alert(retorno);
            console.log(retorno);
        });
    }
}
function ModificarBarbijo(barbijo) {
    VerificarToken();
    CrearForm();
    $("#color").val(barbijo.color);
    $("#tipo").val(barbijo.tipo);
    $("#precio").val(barbijo.precio);
    $("#btnEnviar").html("Modificar");
    $("#divHidden").val(barbijo.id);
    //console.log($("#divHidden").val());
}
function CrearForm() {
    var form = '<form action="" id="loginForm" method="post" class="well form-horizontal col-md-6" style="background-color:darkcyan;">' +
        '<div class="form-group">' +
        '<div class="col-md-12 inputGroupContainer">' +
        '<div class="input-group">' +
        '<span class="input-group-addon"><i class="fas fa-palette"></i></span>' +
        '<input type="text" name="color" id="color" class="form-control" placeholder="Color">' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="form-group">' +
        '<div class="col-md-12 inputGroupContainer">' +
        '<div class="input-group">' +
        '<span class="input-group-addon"><i class="fas fa-car"></i></span>' +
        '<input type="text" name="tipo" id="tipo" class="form-control" placeholder="Tipo">' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="form-group">' +
        '<div class="col-md-12 inputGroupContainer">' +
        '<div class="input-group">' +
        '<span class="input-group-addon"><i class="fas fa-dollar-sign"></i></span>' +
        '<input type="text" name="precio" id="precio" class="form-control" placeholder="Precio">' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="form-group">' +
        '<label class="control-label col-md-1"></label>' +
        '<button class="btn btn-success col-md-4" type="button" id="btnEnviar" onclick="AltaBarbijo()">' +
        'Agregar' +
        '</button>' +
        '<label class="control-label col-md-1"></label>' +
        '<button class="btn btn-warning col-md-4" type="reset">' +
        'Limpiar' +
        '</button>' +
        '</div>' +
        '</form>';
    var aux = document.getElementById("divUsuarios");
    if (aux != null)
        aux.innerHTML = form;
}
function AltaBarbijo() {
    VerificarToken();
    var color = $("#color").val();
    var tipo = $("#tipo").val();
    var precio = $("#precio").val();
    var dato = {};
    dato.color = color;
    dato.tipo = tipo;
    dato.precio = precio;
    var jwt = localStorage.getItem('token');
    if ($("#divHidden").val() != 0) {
        var id_barbijo = $("#divHidden").val();
        dato.id = id_barbijo;
        $("#divHidden").val(0);
        $.ajax({
            type: 'PUT',
            url: "./BACKEND/",
            dataType: "json",
            data: { "barbijo": JSON.stringify(dato) },
            headers: { "token": jwt },
            async: true
        })
            .done(function (resultado) {
            if (resultado.exito) {
                ObtenerListadoBarbijos();
            }
            else {
                $('#error').removeClass("hide");
                var aux = void 0;
                aux = document.getElementById("error");
                if (aux != null)
                    aux.innerHTML = resultado.mensaje + '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            }
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            var retorno = JSON.parse(jqXHR.responseText);
            alert(retorno.mensaje);
            console.log(retorno);
        });
    }
    else {
        $.ajax({
            type: 'POST',
            url: "./BACKEND/",
            dataType: "json",
            data: { "barbijo": JSON.stringify(dato) },
            //headers : {"token":jwt},
            async: true
        })
            .done(function (resultado) {
            if (resultado.exito) {
                ObtenerListadoBarbijos();
                $("#exito").removeClass("hide");
                var aux = void 0;
                aux = document.getElementById("exito");
                if (aux != null)
                    aux.innerHTML = resultado.mensaje + '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            }
            /*else
            {
                $('#error').removeClass("hide");

                let aux;
                aux=document.getElementById("error");
                if(aux!=null)
                    aux.innerHTML = resultado.mensaje;
            }*/
        })
            .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
            var retorno = JSON.parse(jqXHR.responseText);
            $('#error').removeClass("hide");
            var aux;
            aux = document.getElementById("error");
            if (aux != null)
                aux.innerHTML = JSON.parse(jqXHR.responseText).mensaje + '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            //console.log(jqXHR.responseText);
        });
    }
}
function FiltradoMayor() {
    VerificarToken();
    var tabla = "";
    var xhr = new XMLHttpRequest();
    var token = localStorage.getItem('token');
    xhr.open('GET', './BACKEND/barbijos/');
    xhr.setRequestHeader('token', token);
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = JSON.parse(xhr.responseText);
            //console.log(obj.tabla);
            var aux = ((obj.tabla)).filter(function (barbijo, index, array) { return barbijo.precio > 250; });
            //console.log(aux);
            tabla = ArmarTablaBarbijos(aux);
            document.getElementById("divUsuarios").innerHTML = '';
            document.getElementById("divUsuarios").innerHTML = tabla;
        }
    };
}
function FiltradoPromedio() {
    VerificarToken();
    var xhr = new XMLHttpRequest();
    var token = localStorage.getItem('token');
    xhr.open('GET', './BACKEND/barbijos/');
    xhr.setRequestHeader('token', token);
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = JSON.parse(xhr.responseText);
            console.log(obj.tabla);
            var obj_barbijos = obj.tabla;
            var promedioPrecio = obj_barbijos.reduce(function (anterior, actual, index, array) {
                /*console.log("Anterior:"+anterior);
                console.log("Actual:"+actual.precio);*/
                return anterior + parseFloat(actual.precio.substr( /*1*/));
            }, 0) / obj_barbijos.length;
            console.log(promedioPrecio);
            var retorno = '<button type="button" class="close" data-dismiss="alert">&times;</button> El precio promedio de barbijos es de ' + promedioPrecio.toFixed(2);
            $("#info").html(retorno);
            $('#info').removeClass("hide");
        }
    };
}
function FiltradoEmpleados() {
    VerificarToken();
    var tabla = "";
    var xhr = new XMLHttpRequest();
    var token = localStorage.getItem('token');
    xhr.open('GET', './BACKEND/');
    //xhr.setRequestHeader('token', token);
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var obj = JSON.parse(xhr.responseText);
            var aux = ((obj.tabla)).filter(function (user, index, array) { return user.perfil.toLowerCase() == "empleado"; });
            //console.log(aux);
            tabla = ArmarTablaFiltrada(JSON.stringify(aux));
            document.getElementById("divBarbijos").innerHTML = '';
            document.getElementById("divBarbijos").innerHTML = tabla;
        }
    };
}
function ArmarTablaFiltrada(usuarios) {
    var tabla = '<table class="table ">';
    tabla += '<tr><th>Nombre</th><th>Foto</th></tr>';
    if (usuarios === false) {
        tabla = '<tr><td>---</td><td>---</td><td>---</td><td>---</td><th>---</td></tr>';
        $('#error').removeClass("hide");
        var aux = void 0;
        aux = document.getElementById("error");
        if (aux != null)
            aux.innerHTML = "No se puedo acceder a la tabla de usuarios!";
    }
    else {
        usuarios = JSON.parse(usuarios);
        usuarios.forEach(function (cd) {
            tabla += "<tr><td>" + cd.nombre + "</td>" +
                "<td>" + "<img style='width: 50px; height: 50px;' src=./BACKEND/fotos/" + cd.foto + ">" + "</td>" +
                "</tr>";
        });
    }
    tabla += "</table>";
    return tabla;
}
function PDFUsuarios() {
    VerificarToken();
    var xhr = new XMLHttpRequest();
    var token = localStorage.getItem('token');
    xhr.open('GET', './BACKEND/pdf/usuarios');
    xhr.setRequestHeader('token', token);
    xhr.responseType = "blob";
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var blob = new Blob([xhr.response], { type: 'application/pdf' }), fileURL = URL.createObjectURL(blob);
            // open new URL
            window.open(fileURL, '_blank');
            //window.open(xhr.response);
        }
    };
}
function PDFBarbijos() {
    VerificarToken();
    var xhr = new XMLHttpRequest();
    var token = localStorage.getItem('token');
    xhr.open('GET', './BACKEND/pdf/barbijos');
    xhr.setRequestHeader('token', token);
    xhr.responseType = "blob";
    xhr.send();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var blob = new Blob([xhr.response], { type: 'application/pdf' }), fileURL = URL.createObjectURL(blob);
            // open new URL
            window.open(fileURL, '_blank');
            //window.open(xhr.response);
        }
    };
}
//# sourceMappingURL=principal.js.map
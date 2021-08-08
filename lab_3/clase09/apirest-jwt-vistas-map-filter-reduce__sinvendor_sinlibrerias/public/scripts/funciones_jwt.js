/// <reference path="../node_modules/@types/jquery/index.d.ts" />
//Genero una constante con la url de la api, porque como es siempre el mismo archivo (el index.php)
//la url vaa ser el http, con la direccion del servidor virtua que este usando la api 
var APIREST_JWT = "http://ejemplo_apirest_vistas/";
function MostrarLogin() {
    $("#divResultado").html("");
    var form = '<h4 style="padding-top:1em;">LOGIN</h4>\
                        <div class="row justify-content-center">\
                            <div class="col-md-8">\
                                <form class="was-validated">\
                                    <div class="form-group">\
                                        <label for="correo">Correo electrónico:</label>\
                                        <input type="email" class="form-control" id="correo" placeholder="Ingresar correo electrónico" name="correo"\
                                            required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="clave">Clave:</label>\
                                        <input type="password" class="form-control" id="clave" placeholder="Ingresar contraseña"\
                                            name="clave" required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="row justify-content-between">\
                                        <button type="reset" class="btn btn-danger">Limpiar</button>\
                                        <button type="submit" class="btn btn-primary" onclick="Login(event)" >Enviar</button>\
                                    </div>\
                                </form>\
                            </div>\
                        </div><br>\
                        <div id="alerta" class="invisible">\
                            <div id="alert_danger" class="alert alert-danger">\
                            <span id="error_message"></span></div>\
                        </div>';
    $("#divResultado").html(form);
}
function ArmarAlert(mensaje, tipo) {
    if (tipo === void 0) { tipo = "success"; }
    var alerta = '<div id="alert_' + tipo + '" class="alert alert-' + tipo + ' alert-dismissable">';
    alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    alerta += '<span class="d-inline-block text-truncate" style="max-width: 450px;">' + mensaje + ' </span></div>';
    return alerta;
}
function Login(e) {
    e.preventDefault();
    var correo = $("#correo").val();
    var clave = $("#clave").val();
    var dato = {};
    dato.correo = correo;
    dato.clave = clave;
    $.ajax({
        type: 'POST',
        url: APIREST_JWT + "login/",
        dataType: "json",
        data: { "obj_json": JSON.stringify(dato) },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        var mensaje = 'Usuario válido!';
        var tipo = 'success';
        if (resultado.exito) {
            //GUARDO EN EL LOCALSTORAGE
            localStorage.setItem("jwt", resultado.jwt);
        }
        else {
            mensaje = resultado.mensaje;
            tipo = 'danger';
        }
        var alerta = ArmarAlert(mensaje, tipo);
        $("#divResultado").html(alerta);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        $("#alerta").removeClass("invisible");
        $("#alerta").addClass("visible");
        $("#error_message").html(retorno.mensaje);
    });
}
function VerificarJWT() {
    $("#divResultado").html("");
    //RECUPERO DEL LOCALSTORAGE
    var jwt = localStorage.getItem("jwt");
    $.ajax({
        type: 'GET',
        url: APIREST_JWT + "login/test",
        dataType: "json",
        data: {},
        headers: { "token": jwt },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        var mensaje = '';
        var tipo = 'success';
        var app = '';
        var usuario;
        if (resultado.exito) {
            app = resultado.datos.payload.app;
            usuario = resultado.datos.payload.data;
            mensaje = app + "<br>" + JSON.stringify(usuario);
            $("#usuario_info").html("USUARIO: " + usuario.apellido + ", " + usuario.nombre);
        }
        else {
            mensaje = resultado.mensaje;
            tipo = 'danger';
        }
        var alerta = ArmarAlert(mensaje, tipo);
        $("#divResultado").html(alerta);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
function Logout() {
    localStorage.removeItem("jwt");
    var alerta = ArmarAlert('Usuario deslogueado!');
    $("#divResultado").html(alerta);
    $("#usuario_info").html("---");
}
function ObtenerListadoCDs() {
    $("#divResultado").html("");
    var jwt = localStorage.getItem("jwt");
    $.ajax({
        type: 'GET',
        url: APIREST_JWT + "json_bd/",
        dataType: "json",
        data: {},
        headers: { "token": jwt },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        if (resultado.exito) {
            var tabla = ArmarTablaCDs(resultado.datos);
            $("#divResultado").html(tabla);
            $('[data-action="modificar"]').on('click', function (e) {
                var obj_cd_string = $(this).attr("data-obj_cd");
                var obj_cd = JSON.parse(obj_cd_string);
                var formulario = MostrarFormCD("modificacion", obj_cd);
                $("#cuerpo_modal_cd").html(formulario);
            });
            $('[data-action="eliminar"]').on('click', function (e) {
                var obj_cd_string = $(this).attr("data-obj_cd");
                var obj_cd = JSON.parse(obj_cd_string);
                var formulario = MostrarFormCD("baja", obj_cd);
                $("#cuerpo_modal_cd").html(formulario);
            });
        }
        else {
            var alerta = ArmarAlert(resultado.mensaje, 'danger');
            $("#divResultado").html(alerta);
        }
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
function ArmarTablaCDs(cds) {
    var tabla = '<table class="table table-dark table-hover">';
    tabla += '<tr><th>ID</th><th>TITULO</th><th>CANTANTE</th><th>AÑO</th><th style="width:110px">ACCIONES</th></tr>';
    if (cds === false) {
        tabla += '<tr><td>---</td><td>---</td><td>---</td><td>---</td><th>---</td></tr>';
    }
    else {
        cds.forEach(function (cd) {
            tabla += "<tr><td>" + cd.id + "</td><td>" + cd.titulo + "</td><td>" + cd.cantante + "</td><td>" + cd.año + "</td><td>" +
                "<a href='#' class='btn btn-success' data-action='modificar' data-obj_cd='" + JSON.stringify(cd) + "' title='Modificar'" +
                " data-toggle='modal' data-target='#ventana_modal_cd' ><i class='bi bi-pencil'></i></a>" +
                "<a href='#' class='btn btn-danger' data-action='eliminar' data-obj_cd='" + JSON.stringify(cd) + "' title='Eliminar'" +
                " data-toggle='modal' data-target='#ventana_modal_cd' ><i class='bi bi-x-circle'></i></a>" +
                "</td></tr>";
        });
    }
    tabla += "</table>";
    return tabla;
}
function BuscarCDPorId() {
    $("#divResultado").html("");
    var jwt = localStorage.getItem("jwt");
    var id = $("#id_cd").val();
    $.ajax({
        type: 'GET',
        url: APIREST_JWT + "json_bd/" + id,
        dataType: "json",
        data: {},
        headers: { "token": jwt },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        var datos = resultado === false ? false : [resultado];
        var tabla = ArmarTablaCDs(datos);
        $("#divResultado").html(tabla);
        $("#id_cd").val("");
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
function ArmarAltaCD() {
    $("#divResultado").html("");
    var formulario = MostrarFormCD("alta");
    $("#divResultado").html(formulario);
}
function MostrarFormCD(accion, obj_cd) {
    if (obj_cd === void 0) { obj_cd = null; }
    var funcion = "";
    var encabezado = "";
    var solo_lectura = "";
    switch (accion) {
        case "alta":
            funcion = 'AgregarCD(event)';
            encabezado = 'AGREGAR CD';
            break;
        case "baja":
            funcion = 'EliminarCD(event)';
            encabezado = 'ELIMINAR CD';
            solo_lectura = "readonly";
            break;
        case "modificacion":
            funcion = 'ModificarCD(event)';
            encabezado = 'MODIFICAR CD';
            break;
    }
    var id = "";
    var titulo = "";
    var cantante = "";
    var año = "";
    if (obj_cd !== null) {
        id = obj_cd.id;
        titulo = obj_cd.titulo;
        cantante = obj_cd.cantante;
        año = obj_cd.año;
    }
    var form = '<h4 style="padding-top:1em;">' + encabezado + '</h4>\
                        <div class="row justify-content-center">\
                            <div class="col-md-8">\
                                <form class="was-validated">\
                                    <div class="form-group">\
                                        <label for="idCd">ID:</label>\
                                        <input type="text" class="form-control " id="idCd" value="' + id + '" readonly >\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="titulo">Título:</label>\
                                        <input type="text" class="form-control" id="titulo" placeholder="Ingresar título"\
                                            name="titulo" value="' + titulo + '" ' + solo_lectura + ' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="cantante">Cantante:</label>\
                                        <input type="text" class="form-control" id="cantante" placeholder="Ingresar cantante" name="cantante"\
                                            value="' + cantante + '" ' + solo_lectura + ' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="año">Año:</label>\
                                        <input type="number" class="form-control" id="año" placeholder="Ingresar año" name="año"\
                                            value="' + año + '" ' + solo_lectura + ' required>\
                                        <div class="valid-feedback">OK.</div>\
                                        <div class="invalid-feedback">Valor requerido.</div>\
                                    </div>\
                                    <div class="row justify-content-between">\
                                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cerrar">\
                                        <button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="' + funcion + '" >Aceptar</button>\
                                    </div>\
                                </form>\
                            </div>\
                        </div>';
    return form;
}
function AgregarCD(e) {
    e.preventDefault();
    var jwt = localStorage.getItem("jwt");
    var titulo = $("#titulo").val();
    var cantante = $("#cantante").val();
    var año = $("#año").val();
    $.ajax({
        type: 'POST',
        url: APIREST_JWT + "json_bd/",
        dataType: "json",
        data: { "titulo": titulo, "cantante": cantante, "anio": año },
        headers: { "token": jwt },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        var alerta = ArmarAlert('CD agregado!');
        $("#divResultado").html(alerta);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = JSON.parse(jqXHR.responseText);
        var alerta = ArmarAlert(retorno.mensaje, "danger");
        $("#divResultado").html(alerta);
    });
}
function ModificarCD(e) {
    e.preventDefault();
    var jwt = localStorage.getItem("jwt");
    var id = $("#idCd").val();
    var titulo = $("#titulo").val();
    var cantante = $("#cantante").val();
    var año = $("#año").val();
    var dato = {};
    dato.id = id;
    dato.titulo = titulo;
    dato.cantante = cantante;
    dato.anio = año;
    $.ajax({
        type: 'PUT',
        url: APIREST_JWT + "json_bd/",
        dataType: "json",
        data: JSON.stringify(dato),
        headers: { "token": jwt, "content-type": "application/json" },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        ObtenerListadoCDs();
        $("#cuerpo_modal_cd").html("");
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = jqXHR.responseText;
        var alerta = ArmarAlert(retorno, "danger");
        $("#divResultado").html(alerta);
    });
}
function EliminarCD(e) {
    e.preventDefault();
    var jwt = localStorage.getItem("jwt");
    var id = $("#idCd").val();
    var dato = {};
    dato.id = id;
    $.ajax({
        type: 'DELETE',
        url: APIREST_JWT + "json_bd/",
        dataType: "json",
        data: JSON.stringify(dato),
        headers: { "token": jwt, "content-type": "application/json" },
        async: true
    })
        .done(function (resultado) {
        console.log(resultado);
        ObtenerListadoCDs();
        $("#cuerpo_modal_cd").html("");
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        var retorno = jqXHR.responseText;
        var alerta = ArmarAlert(retorno, "danger");
        $("#divResultado").html(alerta);
    });
}

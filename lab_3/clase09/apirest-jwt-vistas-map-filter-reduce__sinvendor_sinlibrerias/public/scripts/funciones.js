/// <reference path="../node_modules/@types/jquery/index.d.ts" />
//Genero una constante con la url de la api, porque como es siempre el mismo archivo (el index.php)
//la url vaa ser el http, con la direccion del servidor virtua que este usando la api 
var APIREST = "http://ejemplo_apirest_vistas/";
$(function () {
    $("#btnMarcas").on("click", function () {
        ArmarComboMarca();
    });
    $("#btnColores").on("click", function () {
        ArmarComboColor();
    });
});
function ApiRestGet() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    $.ajax({
        type: 'GET',
        url: APIREST,
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        $("#divResultado").html(resultado.mensaje);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function ApiRestPost() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    $.ajax({
        type: 'POST',
        url: APIREST,
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        $("#divResultado").html(resultado.mensaje);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function ApiRestPut() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    $.ajax({
        type: 'PUT',
        url: APIREST,
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        $("#divResultado").html(resultado.mensaje);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function ApiRestDelete() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    $.ajax({
        type: 'DELETE',
        url: APIREST,
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        $("#divResultado").html(resultado.mensaje);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function ApiRestGetListadoAutos() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    $.ajax({
        type: 'GET',
        url: APIREST + "listado/autos",
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        $("#divResultado").html(resultado);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function ApiRestGetListadoAutosTabla() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    $.ajax({
        type: 'GET',
        url: APIREST + "listado/autos",
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        var obj_autos = JSON.parse(resultado);
        var tabla = ArmarTablaAutos(obj_autos);
        $("#divResultado").html(tabla);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function ArmarTablaAutos(autos) {
    var tabla = '<table class="table table-dark table-hover">';
    tabla += '<tr><th>ID</th><th>MARCA</th><th>PRECIO</th><th>COLOR</th><th>MODELO</th></tr>';
    autos.forEach(function (auto) {
        tabla += '<tr><td>' + auto.Id + '</td><td>' + auto.Marca + '</td><td>' + auto.Precio + '</td><td>' + auto.Color + '</td><th>' + auto.Modelo + '</td></tr>';
    });
    tabla += "</table>";
    return tabla;
}
function ApiRestGetListadoAutosLocalStorage() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    $.ajax({
        type: 'GET',
        url: APIREST + "listado/autos",
        dataType: "json",
        data: {},
        async: true
    })
        .done(function (resultado) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        //GUARDO EN EL LOCALSTORAGE
        localStorage.setItem("autos", resultado);
        var alerta = '<div id="alert_success" class="alert alert-success alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'Autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    })
        .fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
}
function ObtenerAutosDelLocalStorage() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    var autos = localStorage.getItem("autos");
    var alerta = "";
    var tabla = "";
    if (autos !== null) {
        tabla = ArmarTablaAutos(JSON.parse(autos));
        $("#divResultado").html(tabla);
    }
    else {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    }
}
function ObtenerIdMarcas() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    var autos = localStorage.getItem("autos");
    var alerta = "";
    if (autos !== null) {
        var obj_autos = JSON.parse(autos);
        var soloMarcas = obj_autos.map(function (auto, index, array) {
            var data = {};
            data.id = auto.Id;
            data.marca = auto.Marca;
            return data;
        });
        var tabla_1 = '<table class="table table-dark table-hover">';
        tabla_1 += '<tr><th>ID</th><th>MARCA</th><th>ACCION</th></tr>';
        soloMarcas.forEach(function (auto) {
            tabla_1 += '<tr><td>' + auto.id + '</td><td>' + auto.marca + '</td><td>';
            tabla_1 += '<button type="button" class="btn btn-info" data-toggle="modal"';
            tabla_1 += 'data-target="#ventana_modal" onclick="VerDetalle(' + auto.id + ')">Ver Detalle</button></td></tr>';
        });
        tabla_1 += "</table>";
        $("#divResultado").html(tabla_1);
    }
    else {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    }
}
function VerDetalle(id) {
    var autos = localStorage.getItem("autos");
    var alerta = "";
    if (autos !== null) {
        var obj_autos = JSON.parse(autos);
        var obj_auto_filtrado = void 0;
        obj_auto_filtrado = obj_autos.filter(function (auto, index, array) { return auto.Id === id; });
        $("#cuerpo_modal").html("ID: " + obj_auto_filtrado[0].Id + "<br>Marca: " + obj_auto_filtrado[0].Marca +
            "<br>Precio: " + obj_auto_filtrado[0].Precio + "<br>Modelo: " + obj_auto_filtrado[0].Modelo +
            "<br>Color: " + obj_auto_filtrado[0].Color);
    }
    else {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    }
}
function ObtenerAutosFiltrados(filtro) {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    var autos = localStorage.getItem("autos");
    var alerta = "";
    if (autos !== null) {
        var obj_autos = JSON.parse(autos);
        var obj_autos_filtrados = void 0;
        switch (filtro) {
            case 'marca':
                obj_autos_filtrados = obj_autos.filter(function (auto, index, array) { return auto.Marca === "Mercedes Benz"; });
                break;
            case 'modelo':
                obj_autos_filtrados = obj_autos.filter(function (auto, index, array) { return auto.Modelo === 1977; });
                break;
            case 'color':
                obj_autos_filtrados = obj_autos.filter(function (auto, index, array) { return auto.Color === "Aquamarine"; });
                break;
            default:
                break;
        }
        var tabla = ArmarTablaAutos(obj_autos_filtrados);
        $("#divResultado").html(tabla);
    }
    else {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    }
}
function ObtenerCantidadAutosPorMarca() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    var autos = localStorage.getItem("autos");
    var alerta = "";
    var retorno = "";
    if (autos !== null) {
        var obj_autos = JSON.parse(autos);
        var marca_1 = $("#cboMarca").val();
        var cantidadPorMarca = obj_autos.reduce(function (anterior, actual, index, array) {
            if (actual.Marca === marca_1) {
                return 1 + anterior;
            }
            return anterior;
        }, 0);
        retorno = '<div id="alert_info" class="alert alert-info alert-dismissable">';
        retorno += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        retorno += 'Hay ' + cantidadPorMarca + ' autos de marca ' + marca_1 + ' </div>';
        $("#divResultado").html(retorno);
    }
    else {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    }
}
function ObtenerPreciosPromedio() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    var autos = localStorage.getItem("autos");
    var alerta = "";
    var retorno = "";
    if (autos !== null) {
        var obj_autos = JSON.parse(autos);
        var promedioPrecio = obj_autos.reduce(function (anterior, actual, index, array) {
            return anterior + parseFloat(actual.Precio.substr(1));
        }, 0) / obj_autos.length;
        retorno = '<div id="alert_info" class="alert alert-info alert-dismissable">';
        retorno += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        retorno += 'El promedio total de autos es de ' + promedioPrecio.toFixed(2) + ' </div>';
        $("#divResultado").html(retorno);
    }
    else {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    }
}
function ObtenerPreciosPromedioPorColor() {
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");
    var autos = localStorage.getItem("autos");
    var alerta = "";
    var retorno = "";
    if (autos !== null) {
        var obj_autos_1 = JSON.parse(autos);
        var color_1 = $("#cboColor").val();
        var promedioPrecios = function () {
            var sumaPrecios = obj_autos_1
                .filter(function (auto, index, array) { return auto.Color === color_1; })
                .reduce(function (anterior, actual, index, array) {
                return anterior + parseFloat(actual.Precio.substr(1));
            }, 0);
            var contadorAutos = obj_autos_1.reduce(function (anterior, actual, index, array) {
                if (actual.Color === color_1) {
                    return 1 + anterior;
                }
                return anterior;
            }, 0);
            return sumaPrecios / contadorAutos;
        }();
        retorno = '<div id="alert_info" class="alert alert-info alert-dismissable">';
        retorno += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        retorno += 'El promedio de autos color ' + color_1 + ' es de ' + promedioPrecios.toFixed(2) + ' </div>';
        $("#divResultado").html(retorno);
    }
    else {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    }
}
function ArmarComboMarca() {
    $("#divResultado").html("");
    var autos = localStorage.getItem("autos");
    var alerta = "";
    if (autos !== null) {
        var obj_autos = JSON.parse(autos);
        var items = obj_autos.map(function (auto, index, array) {
            var marca;
            marca = auto.Marca;
            return marca;
        });
        var items_unicos = items.reduce(function (acc, item) {
            if (!acc.includes(item)) {
                acc.push(item);
            }
            return acc;
        }, []);
        var options_1 = '';
        items_unicos.forEach(function (marca) {
            options_1 += '<option>' + marca + '</option>';
        });
        $("#cboMarca").html(options_1);
    }
    else {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    }
}
function ArmarComboColor() {
    $("#divResultado").html("");
    var autos = localStorage.getItem("autos");
    var alerta = "";
    if (autos !== null) {
        var obj_autos = JSON.parse(autos);
        var items = obj_autos.map(function (auto, index, array) {
            var color;
            color = auto.Color;
            return color;
        });
        var items_unicos = items.reduce(function (acc, item) {
            if (!acc.includes(item)) {
                acc.push(item);
            }
            return acc;
        }, []);
        var options_2 = '';
        items_unicos.forEach(function (color) {
            options_2 += '<option>' + color + '</option>';
        });
        $("#cboColor").html(options_2);
    }
    else {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        $("#divResultado").html(alerta);
    }
}

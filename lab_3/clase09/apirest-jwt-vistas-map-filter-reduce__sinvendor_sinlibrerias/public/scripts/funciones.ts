/// <reference path="../node_modules/@types/jquery/index.d.ts" />

//Genero una constante con la url de la api, porque como es siempre el mismo archivo (el index.php)
//la url vaa ser el http, con la direccion del servidor virtua que este usando la api 
const APIREST:string = "http://ejemplo_apirest_vistas/";

$(function(){

    $("#btnMarcas").on("click", function(){
        ArmarComboMarca();
    });

    $("#btnColores").on("click", function(){
        ArmarComboColor();
    });
});

function ApiRestGet():void {

    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    $.ajax({
        type: 'GET',
        url: APIREST,
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        $("#divResultado").html(resultado.mensaje);
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
}

 function ApiRestPost():void {

    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    $.ajax({
        type: 'POST',
        url: APIREST,
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        $("#divResultado").html(resultado.mensaje);
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
}

 function ApiRestPut():void {

    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    $.ajax({
        type: 'PUT',
        url: APIREST,
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        $("#divResultado").html(resultado.mensaje);
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
}

 function ApiRestDelete():void {

    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    $.ajax({
        type: 'DELETE',
        url: APIREST,
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);
        $("#divResultado").html(resultado.mensaje);
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
}

function ApiRestGetListadoAutos():void {

    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    $.ajax({
        type: 'GET',
        url: APIREST + "listado/autos",
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);

        $("#divResultado").html(resultado);
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
}

function ApiRestGetListadoAutosTabla():void {

    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    $.ajax({
        type: 'GET',
        url: APIREST + "listado/autos",
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {
        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);

        let obj_autos = JSON.parse(resultado);
        let tabla:string = ArmarTablaAutos(obj_autos);

        $("#divResultado").html(tabla);
    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
}

function ArmarTablaAutos(autos):string {

    let tabla:string = '<table class="table table-dark table-hover">';
    tabla += '<tr><th>ID</th><th>MARCA</th><th>PRECIO</th><th>COLOR</th><th>MODELO</th></tr>';

    autos.forEach(auto => {
        tabla += '<tr><td>'+auto.Id+'</td><td>'+auto.Marca+'</td><td>'+auto.Precio+'</td><td>'+auto.Color+'</td><th>'+auto.Modelo+'</td></tr>';
    });

    tabla += "</table>";

    return tabla;
}

function ApiRestGetListadoAutosLocalStorage():void {

    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    $.ajax({
        type: 'GET',
        url: APIREST + "listado/autos",
        dataType: "json",
        data: {},
        async: true
    })
    .done(function (resultado:any) {

        //MUESTRO EL RESULTADO DE LA PETICION
        console.log(resultado);

        //GUARDO EN EL LOCALSTORAGE
        localStorage.setItem("autos", resultado);

        let alerta:string = '<div id="alert_success" class="alert alert-success alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'Autos guardados en LocalStorage! </div>';

        $("#divResultado").html(alerta);

    })
    .fail(function (jqXHR:any, textStatus:any, errorThrown:any) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
}

function ObtenerAutosDelLocalStorage(): void {
    
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    let autos = localStorage.getItem("autos");
    let alerta:string = "";
    let tabla:string = "";

    if (autos !== null) 
    {
        tabla = ArmarTablaAutos(JSON.parse(autos));

        $("#divResultado").html(tabla);   
    } 
    else 
    {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        
        $("#divResultado").html(alerta);
    }
}

function ObtenerIdMarcas():void {
    
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    let autos = localStorage.getItem("autos");
    let alerta:string = "";

    if (autos !== null) 
    {
        let obj_autos = JSON.parse(autos);

        let soloMarcas = obj_autos.map((auto, index, array) => {
                                                                let data : any = {};
                                                                data.id = auto.Id;
                                                                data.marca = auto.Marca;
                                                                return data;
                                                            });

        let tabla:string = '<table class="table table-dark table-hover">';
        tabla += '<tr><th>ID</th><th>MARCA</th><th>ACCION</th></tr>';
    
        soloMarcas.forEach(auto => {
            tabla += '<tr><td>'+auto.id+'</td><td>'+auto.marca+'</td><td>';
            tabla += '<button type="button" class="btn btn-info" data-toggle="modal"';
            tabla += 'data-target="#ventana_modal" onclick="VerDetalle('+auto.id+')">Ver Detalle</button></td></tr>';
        });
    
        tabla += "</table>";
    
        $("#divResultado").html(tabla);   
    } 
    else 
    {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        
        $("#divResultado").html(alerta);
    }
}

function VerDetalle(id:number): void {
    
    let autos = localStorage.getItem("autos");
    let alerta:string = "";

    if (autos !== null) 
    {
        let obj_autos = JSON.parse(autos);

        let obj_auto_filtrado;
        obj_auto_filtrado = obj_autos.filter((auto, index, array) => auto.Id === id);

        $("#cuerpo_modal").html("ID: " + obj_auto_filtrado[0].Id + "<br>Marca: "+ obj_auto_filtrado[0].Marca + 
                            "<br>Precio: " + obj_auto_filtrado[0].Precio + "<br>Modelo: " + obj_auto_filtrado[0].Modelo + 
                            "<br>Color: " + obj_auto_filtrado[0].Color);
    }
    else 
    {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        
        $("#divResultado").html(alerta);
    }
}

function ObtenerAutosFiltrados(filtro:string):void {
    
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    let autos = localStorage.getItem("autos");
    let alerta:string = "";

    if (autos !== null) 
    {
        let obj_autos = JSON.parse(autos);

        let obj_autos_filtrados;
        
        switch (filtro) {
            case 'marca':
                obj_autos_filtrados = obj_autos.filter((auto, index, array) => auto.Marca === "Mercedes Benz");
                break;

            case 'modelo':
                obj_autos_filtrados = obj_autos.filter((auto, index, array) => auto.Modelo === 1977);
                break;

            case 'color':
                obj_autos_filtrados = obj_autos.filter((auto, index, array) => auto.Color === "Aquamarine");
                break;
        
            default:
                break;
        }

        let tabla = ArmarTablaAutos(obj_autos_filtrados);

        $("#divResultado").html(tabla);   
    } 
    else 
    {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        
        $("#divResultado").html(alerta);
    }
}

function ObtenerCantidadAutosPorMarca():void {
    
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    let autos = localStorage.getItem("autos");
    let alerta:string = "";
    let retorno:string = "";

    if (autos !== null) 
    {
        let obj_autos = JSON.parse(autos);
        
        let marca = $("#cboMarca").val();

        let cantidadPorMarca = obj_autos.reduce((anterior, actual, index, array) => {
            if (actual.Marca === marca) {
              return 1 + anterior;
            }
            return anterior;
          }, 0);

        retorno = '<div id="alert_info" class="alert alert-info alert-dismissable">';
        retorno += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        retorno += 'Hay ' + cantidadPorMarca + ' autos de marca ' + marca + ' </div>';

        $("#divResultado").html(retorno);   
    } 
    else 
    {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        
        $("#divResultado").html(alerta);
    }
}

function ObtenerPreciosPromedio():void {
    
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    let autos = localStorage.getItem("autos");
    let alerta:string = "";
    let retorno:string = "";

    if (autos !== null) 
    {
        let obj_autos = JSON.parse(autos);       

        let promedioPrecio = obj_autos.reduce((anterior, actual, index, array) => {
            return anterior + parseFloat(actual.Precio.substr(1));
          }, 0) / obj_autos.length;

        retorno = '<div id="alert_info" class="alert alert-info alert-dismissable">';
        retorno += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        retorno += 'El promedio total de autos es de ' + promedioPrecio.toFixed(2) + ' </div>';

        $("#divResultado").html(retorno);   
    } 
    else 
    {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        
        $("#divResultado").html(alerta);
    }
}

function ObtenerPreciosPromedioPorColor():void {
    
    //LIMPIO EL CONTENIDO DEL DIV    
    $("#divResultado").html("");

    let autos = localStorage.getItem("autos");
    let alerta:string = "";
    let retorno:string = "";

    if (autos !== null) 
    {
        let obj_autos = JSON.parse(autos);
        
        let color = $("#cboColor").val();

        let promedioPrecios = function () {

            var sumaPrecios = obj_autos
                .filter((auto, index, array) => auto.Color === color)
                .reduce((anterior, actual, index, array) => {
                    return anterior + parseFloat(actual.Precio.substr(1));
                }, 0);

                var contadorAutos = obj_autos.reduce((anterior, actual, index, array) => {
                        if (actual.Color === color) {
                            return 1 + anterior;
                        }
                        return anterior;
                    }, 0);

                return sumaPrecios / contadorAutos;
        }();

        retorno = '<div id="alert_info" class="alert alert-info alert-dismissable">';
        retorno += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        retorno += 'El promedio de autos color ' + color + ' es de ' + promedioPrecios.toFixed(2) + ' </div>';

        $("#divResultado").html(retorno);  
    } 
    else 
    {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        
        $("#divResultado").html(alerta);
    }
}

function ArmarComboMarca():void {
       
    $("#divResultado").html("");

    let autos = localStorage.getItem("autos");
    let alerta:string = "";

    if (autos !== null) 
    {
        let obj_autos = JSON.parse(autos);
        
        let items = obj_autos.map((auto, index, array) => {
            let marca;
            marca = auto.Marca;
            return marca;
        });

        let items_unicos:any = items.reduce((acc,item)=>{
            if(!acc.includes(item)){
                acc.push(item);
            }
            return acc;
          },[]);

        let options:string = '';

        items_unicos.forEach(marca => {
            options += '<option>'+marca+'</option>';
        });

        $("#cboMarca").html(options);
    } 
    else 
    {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        
        $("#divResultado").html(alerta);
    }
}

function ArmarComboColor():void {
    
    $("#divResultado").html("");

    let autos = localStorage.getItem("autos");
    let alerta:string = "";

    if (autos !== null) 
    {
        let obj_autos = JSON.parse(autos);
        
        let items = obj_autos.map((auto, index, array) => {
            let color;
            color = auto.Color;
            return color;
        });

        let items_unicos:any = items.reduce((acc,item)=>{
            if(!acc.includes(item)){
                acc.push(item);
            }
            return acc;
          },[]);
        let options:string = '';

        items_unicos.forEach(color => {
            options += '<option>'+color+'</option>';
        });

        $("#cboColor").html(options);
    } 
    else 
    {
        alerta = '<div id="alert_danger" class="alert alert-danger alert-dismissable">';
        alerta += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        alerta += 'NO hay autos guardados en LocalStorage! </div>';
        
        $("#divResultado").html(alerta);
    }
}
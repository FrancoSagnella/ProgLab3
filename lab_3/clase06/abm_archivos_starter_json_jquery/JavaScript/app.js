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
/// <reference path="ajax.ts" />
/// <reference path="./libs/jquery/index.d.ts" />
window.onload = function () {
    Main.MostrarGrilla();
};
var Main;
(function (Main) {
    var ajax = new Ajax();
    $(function () {
        $("#archivo").on("change", VisualizarFoto);
        $("#guardar").on("click", AgregarProducto);
        $("#reset").on("click", LimpiarForm);
    });
    function MostrarGrilla() {
        $.ajax({
            type: "POST",
            url: "./administracion.php",
            dataType: "text",
            data: "queHago=mostrarGrilla",
            async: true
        })
            .done(MostrarGrillaSuccess)
            .fail(Fail);
    }
    Main.MostrarGrilla = MostrarGrilla;
    function AgregarProducto() {
        var foto = document.getElementById("archivo").files;
        var queHagoObj = $("#hdnQueHago").val();
        var codBarra = $("#codBarra").val();
        var nombre = $("#nombre").val();
        if (foto != undefined && foto.length > 0) {
            var form = new FormData();
            form.append("queHago", queHagoObj);
            form.append("codBarra", codBarra);
            form.append("nombre", nombre);
            form.append("archivo", foto[0]);
            $.ajax({
                type: 'POST',
                url: "./administracion.php",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                async: true
            })
                .done(AltaSuccess)
                .fail(Fail);
        }
        else {
            alert("No se selecciono foto");
        }
    }
    Main.AgregarProducto = AgregarProducto;
    function EliminarProducto(prod) {
        prod = JSON.parse(prod);
        if (!confirm("Desea ELIMINAR el PRODUCTO " + prod.codBarra + "??")) {
            return;
        }
        var form = new FormData();
        form.append("queHago", "eliminar");
        form.append("codBarra", prod.codBarra);
        $.ajax({
            type: 'POST',
            url: "./administracion.php",
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: form,
            async: true
        })
            .done(DeleteSuccess)
            .fail(Fail);
    }
    Main.EliminarProducto = EliminarProducto;
    function ModificarProducto(prod) {
        prod = JSON.parse(prod);
        $("#codBarra").val(prod.codBarra.toString());
        $("#nombre").val(prod.nombre);
        $("#hdnQueHago").val("modificar");
        if (prod.pathFoto != null) {
            $("#img").attr("src", "./archivos/" + prod.pathFoto);
        }
        $("#codBarra").prop("readOnly", true);
    }
    Main.ModificarProducto = ModificarProducto;
    function LimpiarForm() {
        $("#hdnQueHago").val("agregar");
        $("#img").attr("src", "default-avatar.png");
        $("#codBarra").prop("readOnly", false);
    }
    Main.LimpiarForm = LimpiarForm;
    function VisualizarFoto() {
        if ($("#archivo").val() === "") {
            $("#img").attr("src", "default-avatar.png");
            return;
        }
        var foto = document.getElementById("archivo").files;
        //let foto = $("#archivo").attr("files");
        //(<HTMLImageElement>document.getElementById("img")).src = foto[0].name;
        var reader = new FileReader();
        reader.readAsDataURL(foto[0]);
        reader.onload = function () {
            $("#img").attr("src", reader.result);
        };
    }
    Main.VisualizarFoto = VisualizarFoto;
    function MostrarGrillaSuccess(grilla) {
        console.clear();
        console.log(grilla);
        $("#divGrilla").html(grilla);
    }
    function DeleteSuccess(retorno) {
        console.clear();
        console.log(retorno.mensaje);
        alert(retorno.mensaje);
        if (retorno.exito)
            MostrarGrilla();
    }
    function AltaSuccess(retorno) {
        console.clear();
        console.log(retorno.mensaje);
        alert(retorno.mensaje);
        $("#reset").trigger("click");
        if (retorno.exito)
            MostrarGrilla();
    }
    function ModificarSuccess(retorno) {
        console.clear();
        console.log(retorno.mensaje);
        alert(retorno.mensaje);
        $("#reset").trigger("click");
        if (retorno.exito)
            MostrarGrilla();
    }
    function Fail(jqXHR, textStatus, errorThrown) {
        console.clear();
        console.log(jqXHR.responseText);
        alert("Ha ocurrido un ERROR!!!");
    }
})(Main || (Main = {}));

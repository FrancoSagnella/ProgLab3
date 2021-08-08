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
            if (params === void 0) { params = ""; }
            var parametros = params.length > 0 ? params : "";
            _this._xhr.open('POST', ruta, true);
            _this._xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            _this._xhr.send(parametros);
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
window.onload = function () {
    MostrarLista();
};
var ajax = new Ajax();
function AdministrarValidaciones() {
    var accion = document.getElementById("accion").value;
    var valueDni = document.getElementById("txtDni").value;
    var dniMin = document.getElementById("txtDni").min;
    var dniMax = document.getElementById("txtDni").max;
    var valueApellido = document.getElementById("txtApellido").value;
    var valueNombre = document.getElementById("txtNombre").value;
    var valueSueldo = document.getElementById("txtSueldo").value;
    var sueldoMin = document.getElementById("txtSueldo").min;
    var sueldoMax = obtenerSueldoMaximo(obtenerTurnoSeleccionado());
    var valueSexo = document.getElementById("cboSexo").value;
    AdministrarSpanError("spanDni", validarCamposVacios(valueDni));
    AdministrarSpanError("spanDni", validarRangoNumerico(parseInt(valueDni), parseInt(dniMin), parseInt(dniMax)));
    AdministrarSpanError("spanApellido", validarCamposVacios(valueApellido));
    AdministrarSpanError("spanNombre", validarCamposVacios(valueNombre));
    AdministrarSpanError("spanSueldo", validarCamposVacios(valueSueldo));
    AdministrarSpanError("spanSueldo", validarRangoNumerico(parseInt(valueSueldo), parseInt(sueldoMin), sueldoMax));
    AdministrarSpanError("spanSexo", validarCombo(valueSexo, "---"));
    if (VerificarValidacionesIndex()) {
        var form = new FormData(document.getElementById("form"));
        var xhr_1 = new XMLHttpRequest();
        xhr_1.open('POST', "./backend/administracion.php", true);
        xhr_1.send(form);
        xhr_1.onreadystatechange = function () {
            if (xhr_1.readyState === 4) {
                if (xhr_1.status === 200) {
                    AltaSuccess(xhr_1.responseText);
                }
                else {
                    Fail(xhr_1.status);
                }
            }
        };
        // let params : string = `accion=${accion}&dni=${valueDni}&apellido=${valueApellido}&nombre=${valueNombre}&legajo=${valueLegajo}&sueldo=${valueSueldo}&sexo=${valueSexo}`;
        // ajax.Post("http://localhost/lab_3/TP1/ParteFinal/backend/administracion.php",
        //     AltaSuccess,
        //     params,
        //     Fail);
    }
}
function validarCamposVacios(value) {
    var ret = false;
    if (value != "")
        ret = true;
    return ret;
}
function validarRangoNumerico(value, min, max) {
    var ret = false;
    if (value <= max && value >= min)
        ret = true;
    return ret;
}
function validarCombo(value, notValue) {
    var ret = false;
    if (value != notValue)
        ret = true;
    return ret;
}
function obtenerTurnoSeleccionado() {
    var ret = "";
    var turno = document.getElementsByName("rdoTurno");
    for (var i = 0; i < turno.length; i++) {
        if (turno[i].checked) {
            ret = turno[i].value;
            break;
        }
    }
    return ret;
}
function obtenerSueldoMaximo(turno) {
    var ret = 0;
    switch (turno) {
        case "Maniana":
            ret = 20000;
            break;
        case "Tarde":
            ret = 18500;
            break;
        case "Noche":
            ret = 25000;
            break;
    }
    return ret;
}
function AdministrarValidacionesLogin() {
    var valueDni = document.getElementById("txtDni").value;
    var dniMin = document.getElementById("txtDni").min;
    var dniMax = document.getElementById("txtDni").max;
    var valueApellido = document.getElementById("txtApellido").value;
    AdministrarSpanError("spanDni", validarCamposVacios(valueDni));
    AdministrarSpanError("spanDni", validarRangoNumerico(parseInt(valueDni), parseInt(dniMin), parseInt(dniMax)));
    AdministrarSpanError("spanApellido", validarCamposVacios(valueApellido));
    if (VerificarValidacionesLogin()) {
        var params = "dni=" + valueDni + "&apellido=" + valueApellido;
        ajax.Post("./backend/verificarUsuario.php", LoginSuccess, params, Fail);
    }
}
function AdministrarSpanError(string, boolean) {
    if (boolean != true) {
        document.getElementById(string).style.display = "block";
    }
    else {
        document.getElementById(string).style.display = "none";
    }
}
function VerificarValidacionesLogin() {
    var ret = true;
    if (document.getElementById("spanApellido").style.display == "block"
        || document.getElementById("spanDni").style.display == "block") {
        ret = false;
    }
    return ret;
}
function VerificarValidacionesIndex() {
    var _a;
    var ret = true;
    if (document.getElementById("spanApellido").style.display == "block"
        || document.getElementById("spanDni").style.display == "block"
        || document.getElementById("spanNombre").style.display == "block"
        || document.getElementById("spanSexo").style.display == "block"
        || document.getElementById("spanSueldo").style.display == "block"
        || ((_a = document.getElementById("archivo").files) === null || _a === void 0 ? void 0 : _a.length) == 0) {
        ret = false;
    }
    return ret;
}
//Agrego esto para poder hacer las cosas con ajax
function AdministrarModificar(dni, apellido, nombre, sexo, legajo, sueldo, turno) {
    document.getElementById("accion").value = 'modificar';
    document.getElementById("titulo").innerHTML = "Modificar con BD / Listado de Empleados";
    document.getElementById("txtDni").value = dni;
    document.getElementById("txtDni").readOnly = true;
    document.getElementById("txtApellido").value = apellido;
    document.getElementById("txtNombre").value = nombre;
    document.getElementById("txtLegajo").value = legajo;
    document.getElementById("txtSueldo").value = sueldo;
    document.getElementById("cboSexo").value = sexo;
    //(<HTMLInputElement> document.getElementById("Maniana")).checked = false;
    switch (turno) {
        case "Maniana":
            document.getElementById("maniana").checked = true;
            break;
        case "Tarde":
            document.getElementById("tarde").checked = true;
            break;
        case "Noche":
            document.getElementById("noche").checked = true;
            break;
    }
}
function AdministrarEliminar(legajo) {
    if (!confirm("Desea eliminar al empleado seleccionado? legajo: " + legajo))
        return;
    var parametro = "accion=eliminar&legajo=" + legajo;
    ajax.Post("./backend/eliminar.php", DeleteSuccess, parametro, Fail);
}
function MostrarLista() {
    var parametros = "accion=mostrar";
    ajax.Post("./backend/mostrar.php", MostrarListaSuccess, parametros, Fail);
}
function MostrarListaSuccess(lista) {
    console.clear();
    console.log(lista);
    document.getElementById("divLista").innerHTML = lista;
}
function DeleteSuccess(retorno) {
    console.clear();
    console.log(retorno);
    alert(retorno);
    MostrarLista();
}
function LoginSuccess(retorno) {
    console.clear();
    console.log(retorno);
    alert(retorno);
    if (retorno != "Datos invalidos")
        window.location.href = "./index.php";
}
function AltaSuccess(retorno) {
    console.clear();
    console.log();
    alert(retorno);
    document.getElementById("btnLimpiar").click();
    MostrarLista();
}
function Fail(retorno) {
    console.clear();
    console.log(retorno);
    alert(retorno);
}

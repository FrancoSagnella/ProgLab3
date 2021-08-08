function AdministrarValidaciones(e) {
    var valueDni = document.getElementById("txtDni").value;
    var dniMin = document.getElementById("txtDni").min;
    var dniMax = document.getElementById("txtDni").max;
    var valueApellido = document.getElementById("txtApellido").value;
    var valueNombre = document.getElementById("txtNombre").value;
    var valueLegajo = document.getElementById("txtLegajo").value;
    var legajoMin = document.getElementById("txtLegajo").min;
    var legajoMax = document.getElementById("txtLegajo").max;
    var valueSueldo = document.getElementById("txtSueldo").value;
    var sueldoMin = document.getElementById("txtSueldo").min;
    var sueldoMax = obtenerSueldoMaximo(obtenerTurnoSeleccionado());
    var valueSexo = document.getElementById("cboSexo").value;
    AdministrarSpanError("spanDni", validarCamposVacios(valueDni));
    AdministrarSpanError("spanDni", validarRangoNumerico(parseInt(valueDni), parseInt(dniMin), parseInt(dniMax)));
    AdministrarSpanError("spanApellido", validarCamposVacios(valueApellido));
    AdministrarSpanError("spanNombre", validarCamposVacios(valueNombre));
    AdministrarSpanError("spanLegajo", validarCamposVacios(valueLegajo));
    AdministrarSpanError("spanSueldo", validarCamposVacios(valueSueldo));
    AdministrarSpanError("spanLegajo", validarRangoNumerico(parseInt(valueLegajo), parseInt(legajoMin), parseInt(legajoMax)));
    AdministrarSpanError("spanSueldo", validarRangoNumerico(parseInt(valueSueldo), parseInt(sueldoMin), sueldoMax));
    AdministrarSpanError("spanSexo", validarCombo(valueSexo, "---"));
    if (!VerificarValidacionesIndex())
        e.preventDefault();
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
function AdministrarValidacionesLogin(e) {
    var valueDni = document.getElementById("txtDni").value;
    var dniMin = document.getElementById("txtDni").min;
    var dniMax = document.getElementById("txtDni").max;
    var valueApellido = document.getElementById("txtApellido").value;
    AdministrarSpanError("spanDni", validarCamposVacios(valueDni));
    AdministrarSpanError("spanDni", validarRangoNumerico(parseInt(valueDni), parseInt(dniMin), parseInt(dniMax)));
    AdministrarSpanError("spanApellido", validarCamposVacios(valueApellido));
    if (!VerificarValidacionesLogin())
        e.preventDefault();
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
        || document.getElementById("spanLegajo").style.display == "block"
        || document.getElementById("spanSueldo").style.display == "block"
        || ((_a = document.getElementById("archivo").files) === null || _a === void 0 ? void 0 : _a.length) == 0) {
        ret = false;
    }
    return ret;
}
function AdministrarModificar(dni) {
    document.getElementById("hiddenMod").value = dni;
    document.getElementById("formMod").submit();
}

"use strict";
function ValidadCamposVacios(verificar) {
    var validar = false;
    //verificar=verificar;
    if (verificar.trim() != "" && verificar != null) {
        validar = true;
    }
    return validar;
}
function ValidarRangoNumerico(valor, min, max) {
    var validar = false;
    if (valor >= min && valor <= max) {
        validar = true;
    }
    return validar;
}
function ValidarCombo(valor, valorContrario) {
    var validar = false;
    if (valor != valorContrario) {
        validar = true;
        //  alert(valorContrario + valor);
    }
    return validar;
}
function ObtenerTurnoSeleccionado() {
    var turno = document.getElementsByName("rdoTurno");
    var retorno = "";
    for (var i = 0; turno.length; i++) {
        if (turno[i].checked) {
            retorno = turno[i].value;
            break;
        }
    }
    return retorno;
}
function ObtenerSueldoMaximo(turno) {
    var sueldoMax = 0;
    switch (turno) {
        case "mañana":
            sueldoMax = 20000;
            break;
        case "tarde":
            sueldoMax = 18500;
            break;
        case "noche":
            sueldoMax = 25000;
            break;
        default:
            sueldoMax = -1;
            break;
    }
    return sueldoMax;
}
//# sourceMappingURL=validar2.js.map
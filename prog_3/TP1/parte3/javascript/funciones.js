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
    if (!validarCamposVacios(valueDni)) {
        console.log("El campo de DNI esta vacio");
        alert("El campo DNI esta vacio");
        e.preventDefault();
    }
    if (!validarCamposVacios(valueApellido)) {
        console.log("El campo de Apellido esta vacio");
        alert("El campo Apellido esta vacio");
        e.preventDefault();
    }
    if (!validarCamposVacios(valueNombre)) {
        console.log("El campo de Nombre esta vacio");
        alert("El campo Nombre esta vacio");
        e.preventDefault();
    }
    if (!validarCamposVacios(valueLegajo)) {
        console.log("El campo de Legajo esta vacio");
        alert("El campo Legajo esta vacio");
        e.preventDefault();
    }
    if (!validarCamposVacios(valueSueldo)) {
        console.log("El campo de Sueldo esta vacio");
        alert("El campo Sueldo esta vacio");
        e.preventDefault();
    }
    if (!validarRangoNumerico(parseInt(valueDni), parseInt(dniMin), parseInt(dniMax))) {
        console.log("El rango numerico del DNI es incorrecto, tiene que ser un valor entre 1000000 y 55000000");
        alert("El rango numerico del DNI es incorrecto, tiene que ser un valor entre 1000000 y 55000000");
        e.preventDefault();
    }
    if (!validarRangoNumerico(parseInt(valueLegajo), parseInt(legajoMin), parseInt(legajoMax))) {
        console.log("El rango numerico del Legajo es incorrecto, tiene que ser un valor entre 100 y 550");
        alert("El rango numerico del Legajo es incorrecto, tiene que ser un valor entre 100 y 550");
        e.preventDefault();
    }
    if (!validarRangoNumerico(parseInt(valueSueldo), parseInt(sueldoMin), sueldoMax)) {
        console.log("El rango numerico del Sueldo es incorrecto, tiene que ser un valor entre 8000 y" + sueldoMax);
        alert("El rango numerico del Sueldo es incorrecto, tiene que ser un valor entre 8000 y" + sueldoMax);
        e.preventDefault();
    }
    if (!validarCombo(valueSexo, "---")) {
        console.log("El campo de sexo debe tener seleccionado alguna de las casillas de Masculino o Femenino");
        alert("El campo de sexo debe tener seleccionado alguna de las casillas de Masculino o Femenino");
        e.preventDefault();
    }
    /*if(valido == true)
    {
        (<HTMLFormElement> document.getElementById("form")).submit();
    }
    else
    {
        alert("Complete correctamente todos los campos antes de enviar");
    }*/
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

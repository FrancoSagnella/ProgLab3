"use strict";
function AdministrarValidaciones() {
    var nombre = document.getElementById("txtNombre").value;
    var dni = document.getElementById("txtDni").value;
    var apellido = document.getElementById("txtApellido").value;
    var sexo = document.getElementById("sexo").value;
    var legajo = document.getElementById("txtLegajo").value;
    var sueldo = document.getElementById("txtSueldo").value;
    var validar = true;
    var i = 0;
    alert("entre");
    validar = ValidadCamposVacios(nombre);
    validar == false ? alert("Nombre incorrecto") : console.log("nombre correcto");
    validar == false ? i++ : console.log("nombre correcto");
    validar = ValidadCamposVacios(apellido);
    validar == false ? alert("apellido incorrecto") : console.log("apellido correcto");
    validar == false ? i++ : console.log("apellido correcto");
    validar = ValidadCamposVacios(dni);
    validar == false ? alert("DNI incorrecto") : console.log("DNI correcto");
    validar == false ? i++ : console.log("DNI correcto");
    validar = ValidarRangoNumerico(parseInt(dni), 1000000, 55000000);
    validar == false ? alert("DNI incorrecto") : console.log("DNI correcto");
    validar == false ? i++ : console.log("DNI correcto");
    validar = ValidadCamposVacios(legajo);
    validar == false ? alert("Legajo incorrecto") : console.log("Legajo correcto");
    validar == false ? i++ : console.log("Legajo correcto");
    validar = ValidarRangoNumerico(parseInt(legajo), 100, 550);
    validar == false ? alert("Legajo incorrecto") : console.log("Legajo correcto");
    validar == false ? i++ : console.log("Legajo correcto");
    validar = ValidarCombo(sexo, "--");
    validar == false ? alert("sexo incorrecto") : console.log("sexo correcto");
    validar == false ? i++ : console.log("sexo correcto");
    var turno = ObtenerTurnoSeleccionado();
    var sueldoMaximo = ObtenerSueldoMaximo(turno);
    validar = ValidarRangoNumerico(parseInt(sueldo), 8000, sueldoMaximo);
    // i!=0 ? e.preventDefault() : console.log("todos los datos son correctos");
}
//# sourceMappingURL=validar.js.map
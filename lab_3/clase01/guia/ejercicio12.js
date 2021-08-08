"use strict";
function decirSigno(cadena) {
    var fecha = cadena.split("-");
    var dia = parseInt(fecha[0]);
    var mes = parseInt(fecha[1]);
    var anio = parseInt(fecha[2]);
    var signo = "";
    switch (mes) {
        case 3:
            if (dia >= 21) {
                signo = "aries";
            }
            else {
                signo = "piscis";
            }
            break;
        case 4:
            if (dia >= 21) {
                signo = "tauro";
            }
            else {
                signo = "aries";
            }
            break;
        case 5:
            if (dia >= 21) {
                signo = "geminis";
            }
            else {
                signo = "tauro";
            }
            break;
        case 6:
            if (dia >= 21) {
                signo = "cancer";
            }
            else {
                signo = "geminis";
            }
            break;
        case 7:
            if (dia >= 21) {
                signo = "leo";
            }
            else {
                signo = "cancer";
            }
            break;
        case 8:
            if (dia >= 21) {
                signo = "virgo";
            }
            else {
                signo = "leo";
            }
            break;
        case 9:
            if (dia >= 21) {
                signo = "libra";
            }
            else {
                signo = "virgo";
            }
            break;
        case 10:
            if (dia >= 21) {
                signo = "escorpio";
            }
            else {
                signo = "libra";
            }
            break;
        case 11:
            if (dia >= 21) {
                signo = "sagitario";
            }
            else {
                signo = "escorpio";
            }
            break;
        case 12:
            if (dia >= 21) {
                signo = "capricornio";
            }
            else {
                signo = "sagitario";
            }
            break;
        case 1:
            if (dia >= 21) {
                signo = "acuario";
            }
            else {
                signo = "capricornio";
            }
            break;
        case 2:
            if (dia >= 21) {
                signo = "piscis";
            }
            else {
                signo = "acuario";
            }
            break;
    }
    console.log("Naciste el: " + cadena + " y tu signo es: " + signo);
}
decirSigno("26-12-2002");
//# sourceMappingURL=ejercicio12.js.map
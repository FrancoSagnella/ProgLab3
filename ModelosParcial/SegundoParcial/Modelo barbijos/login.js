"use strict";
/// <reference path="./node_modules/@types/jquery/index.d.ts" />
/*
$(document).ready(function()
{
    loginForm();
});
*/
function Login() {
    var xhr = new XMLHttpRequest();
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var obj = {
        correo: email,
        clave: password,
    };
    var json = JSON.stringify(obj);
    var form = new FormData();
    form.append('user', json);
    xhr.open('POST', './BACKEND/login/', true);
    xhr.setRequestHeader("enctype", "multipart/form-data");
    xhr.send(form);
    xhr.onreadystatechange = function () {
        console.log(xhr.status);
        if (xhr.readyState == 4 && xhr.status == 200) {
            var respuesta = xhr.responseText;
            var objRespuesta = JSON.parse(respuesta);
            var token = objRespuesta.jwt;
            if (objRespuesta.exito == true) {
                localStorage.setItem("token", token);
                window.location.replace("./principal.html");
            }
        }
        else if (xhr.readyState == 4 && xhr.status != 200) {
            $('#errorLogin').removeClass("hide");
            var respuesta_1 = xhr.responseText;
            var objRespuesta_1 = JSON.parse(respuesta_1);
            var aux = void 0;
            aux = document.getElementById("errorLogin");
            if (aux != null)
                aux.innerHTML = objRespuesta_1.Mensaje;
        }
    };
}
/*
function loginForm()
{
    $("#loginForm").preventDefault();
}*/ 
//# sourceMappingURL=login.js.map
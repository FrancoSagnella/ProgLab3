"use strict";
/// <reference path="./node_modules/@types/jquery/index.d.ts" />
function Registro() {
    var xhr = new XMLHttpRequest();
    var regcorreo = document.getElementById("regcorreo").value;
    var regpassword = document.getElementById("regpassword").value;
    var regnombre = document.getElementById("regnombre").value;
    var regapellido = document.getElementById("regapellido").value;
    var regperfil = document.getElementById("regperfil").value;
    var fotoInput = document.getElementById("regfoto");
    //var path = document.getElementById("regfoto").value;
    //var pathFoto = (path.split('\\'))[2];
    var form = new FormData();
    //var json = "{'correo':'" + regcorreo + "','clave':'" + regpassword + "','nombre':'" + regnombre + "','apellido':'" + regapellido + "','perfil':'" + regperfil + "'}";
    var obj = {
        correo: regcorreo,
        clave: regpassword,
        nombre: regnombre,
        apellido: regapellido,
        perfil: regperfil,
    };
    var json = JSON.stringify(obj);
    form.append('usuario', json);
    form.append('foto', fotoInput.files[0]);
    xhr.open('POST', './BACKEND/usuarios/', true);
    xhr.setRequestHeader("enctype", "multipart/form-data");
    xhr.send(form);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            var respuesta = JSON.parse(xhr.responseText);
            if (respuesta.exito == true) {
                window.location.replace("./login.html");
            }
            //(<HTMLInputElement> document.getElementById("errorReg")).type = "";
            //(<HTMLInputElement> document.getElementById("errorReg")).style.display = "block";
            //$('#errorReg').removeClass("hide");
            //$('#errorReg').addClass("alert alert-danger show");
            //$('#errorReg').alert();
            //Segun la respuesta , registro correcto o no poner una ventana que avise lo acontecido    
            //$('#myModal').modal("hide");
            //window.location.replace("./login.php");
        }
        else if (xhr.readyState == 4 && xhr.status != 200) {
            $('#errorReg').removeClass("hide");
            var respuesta_1 = xhr.responseText;
            var objRespuesta = JSON.parse(respuesta_1);
            var aux = void 0;
            aux = document.getElementById("errorReg");
            if (aux != null)
                aux.innerHTML = objRespuesta.Mensaje;
        }
    };
}
//# sourceMappingURL=registro.js.map
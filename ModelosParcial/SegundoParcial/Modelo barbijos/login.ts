/// <reference path="./node_modules/@types/jquery/index.d.ts" />
/*
$(document).ready(function()
{
    loginForm();
});
*/
function Login()
{
    let xhr : XMLHttpRequest = new XMLHttpRequest();
     
    var email : string = (<HTMLInputElement> document.getElementById("email")).value;
    var password : string = (<HTMLInputElement> document.getElementById("password")).value;



    var obj: Object = {
        correo: email,
        clave: password,
    };

    var json = JSON.stringify(obj);

    let form : FormData = new FormData();
    form.append('user', json);
    xhr.open('POST', './BACKEND/login/', true);
    xhr.setRequestHeader("enctype", "multipart/form-data");
    xhr.send(form);  
    
    xhr.onreadystatechange = () => 
    {
        console.log(xhr.status);
        if (xhr.readyState == 4 && xhr.status == 200) 
        {
            var respuesta : string = xhr.responseText;
            
            var objRespuesta : any = JSON.parse(respuesta);

            var token = objRespuesta.jwt;

            

            if(objRespuesta.exito == true)
            {
                localStorage.setItem("token", token);
                window.location.replace("./principal.html");
            }
        }
        else if(xhr.readyState == 4 && xhr.status != 200)
        {
            $('#errorLogin').removeClass("hide");

            let respuesta = xhr.responseText;
            let objRespuesta = JSON.parse(respuesta);

            let aux;
            aux=document.getElementById("errorLogin");
            if(aux!=null)
                aux.innerHTML = objRespuesta.Mensaje;
        }
    }
}
/*
function loginForm()
{
    $("#loginForm").preventDefault();
}*/
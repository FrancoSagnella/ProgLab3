/// <reference path="../node_modules/@types/jquery/index.d.ts" />
var APIREST = "http://SegundoParcial/";
var SegundoParcial;
(function (SegundoParcial) {
    var Login = /** @class */ (function () {
        function Login() {
        }
        Login.Login = function () {
            var correo = $("#email").val();
            var clave = $("#password").val();
            var dato = {};
            dato.correo = correo;
            dato.clave = clave;
            //alert(dato.correo);
            $.ajax({
                type: 'POST',
                url: APIREST + "login/",
                dataType: "json",
                data: { "user": JSON.stringify(dato) },
                async: true
            })
                .done(function (resultado) {
                console.log(resultado);
                if (resultado.exito) {
                    localStorage.setItem("jwt", resultado.jwt);
                    window.location.replace(APIREST + "front-end-principal");
                }
            })
                .fail(function (jqXHR, textStatus, errorThrown) {
                var resultado = JSON.parse(jqXHR.responseText);
                console.log(resultado);
                //alert(resultado.mensaje);
                $("#errorLogin").removeClass("hide");
                $("#errorLogin").html(resultado.mensaje);
            });
        };
        //Esto lo puedo ahcer directamente asociando el location en el boton
        Login.IrRegistro = function () {
            window.location.replace(APIREST + "front-end-registro");
        };
        return Login;
    }());
    SegundoParcial.Login = Login;
})(SegundoParcial || (SegundoParcial = {}));

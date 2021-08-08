/// <reference path="../node_modules/@types/jquery/index.d.ts" />
const APIREST:string = "http://SegundoParcial/";
namespace SegundoParcial
{
    export class Login
    {
        
        public static Login()
        {
            let correo = <string> $("#email").val();
            let clave  = <string> $("#password").val();
            let dato:any = {};
            dato.correo = correo;
            dato.clave = clave;
            
            //alert(dato.correo);

            $.ajax({
                type: 'POST',
                url: APIREST+"login/",
                dataType: "json",
                data: {"user":JSON.stringify(dato)},
                async: true
            }
            )
            .done(function (resultado:any){
                console.log(resultado);
                
                if(resultado.exito)
                {
                    localStorage.setItem("jwt", resultado.jwt);
                    window.location.replace(APIREST+"front-end-principal");
                }

            })
            .fail(function (jqXHR:any, textStatus:any, errorThrown:any){
                let resultado = JSON.parse(jqXHR.responseText);
                console.log(resultado);
                //alert(resultado.mensaje);
                $("#errorLogin").removeClass("hide");
                $("#errorLogin").html(resultado.mensaje);
            });
        }

        //Esto lo puedo ahcer directamente asociando el location en el boton
        public static IrRegistro()
        {
            window.location.replace(APIREST+"front-end-registro");
        }
    }
}
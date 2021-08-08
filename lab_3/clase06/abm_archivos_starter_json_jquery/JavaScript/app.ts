/// <reference path="ajax.ts" />
/// <reference path="./libs/jquery/index.d.ts" />

window.onload = ():void => {
    Main.MostrarGrilla();
}; 

namespace Main{
    
        let ajax : Ajax = new Ajax();
        $(function(){   
            $("#archivo").on("change", VisualizarFoto);
            $("#guardar").on("click", AgregarProducto);
            $("#reset").on("click", LimpiarForm);
        })
    
        export function MostrarGrilla():void {

            $.ajax({
                type:"POST",
                url:"./administracion.php",
                dataType:"text",
                data:"queHago=mostrarGrilla",
                async:true
            })
            .done(MostrarGrillaSuccess)
            .fail(Fail);
        }

        export function AgregarProducto():void {
            
            let foto = (<HTMLInputElement>document.getElementById("archivo")).files;

            let queHagoObj  = <string> $("#hdnQueHago").val();
            let codBarra = <string> $("#codBarra").val();
            let nombre = <string> $("#nombre").val();
            
            if(foto!=undefined && foto.length > 0)
            {
                let form = new FormData();
                form.append("queHago", queHagoObj); 
                form.append("codBarra", codBarra);
                form.append("nombre", nombre);
                form.append("archivo", foto[0]);

                $.ajax({
                    type: 'POST',
                    url: "./administracion.php",
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form,
                    async: true
                }
                )
                .done(AltaSuccess)
                .fail(Fail);
            }
            else{
                alert("No se selecciono foto");
            }
            
        }
        
        export function EliminarProducto(prod:any):void {

            prod = JSON.parse(prod);
            if(!confirm("Desea ELIMINAR el PRODUCTO "+prod.codBarra+"??")){
                return;
            }

            let form = new FormData();
            form.append("queHago", "eliminar")
            form.append("codBarra", prod.codBarra);

            $.ajax({
                type: 'POST',
                url: "./administracion.php",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: form,
                async: true
            })
            .done(DeleteSuccess)
            .fail(Fail);
        }
    
        export function ModificarProducto( y):void {

            prod = JSON.parse(prod);

            $("#codBarra").val(prod.codBarra.toString());
            $("#nombre").val(prod.nombre);
            $("#hdnQueHago").val("modificar");

            if(prod.pathFoto != null)
            {
                $("#img").attr("src", "./archivos/" + prod.pathFoto);
            }

            $("#codBarra").prop("readOnly", true);
        }

        export function LimpiarForm():void{

            $("#hdnQueHago").val("agregar");
            $("#img").attr("src", "default-avatar.png");


            $("#codBarra").prop("readOnly", false);
        }

        export function VisualizarFoto():void
        {
            if($("#archivo").val() === "")
            {
                $("#img").attr("src", "default-avatar.png");
                return;
            }

            let foto = (<HTMLInputElement>document.getElementById("archivo")).files;
            //let foto = $("#archivo").attr("files");
            //(<HTMLImageElement>document.getElementById("img")).src = foto[0].name;
            let reader = new FileReader();

            reader.readAsDataURL(foto[0]);

            reader.onload = function(){
                $("#img").attr("src", <string> reader.result);
            }
        }

        function MostrarGrillaSuccess(grilla:string):void {
            console.clear();
            console.log(grilla);

            $("#divGrilla").html(grilla);
        }

        function DeleteSuccess(retorno:any):void {
            console.clear();
            console.log(retorno.mensaje);
            alert(retorno.mensaje);

            if(retorno.exito)
                MostrarGrilla();
        }
    
        function AltaSuccess(retorno:any):void {
            console.clear();
            console.log(retorno.mensaje);
            alert(retorno.mensaje);

            $("#reset").trigger("click");
            
            if(retorno.exito)
                MostrarGrilla();
        }

        function ModificarSuccess(retorno:any):void {
            console.clear();
            console.log(retorno.mensaje);
            alert(retorno.mensaje);

            $("#reset").trigger("click");

            if(retorno.exito)
                MostrarGrilla();
        }

        function Fail(jqXHR, textStatus, errorThrown):void {
            console.clear();
            console.log(jqXHR.responseText);
            alert("Ha ocurrido un ERROR!!!");
        }
    
}
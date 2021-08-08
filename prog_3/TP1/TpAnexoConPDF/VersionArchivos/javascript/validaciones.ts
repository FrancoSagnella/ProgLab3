/// <reference path="ajax.ts" />

window.onload = ():void => {
    MostrarLista();
}; 

let ajax : Ajax = new Ajax();

function AdministrarValidaciones(): void 
{
    let accion :string = (<HTMLInputElement> document.getElementById("accion")).value;

    let valueDni : string = (<HTMLInputElement> document.getElementById("txtDni")).value;
    let dniMin : string = (<HTMLInputElement> document.getElementById("txtDni")).min;
    let dniMax : string = (<HTMLInputElement> document.getElementById("txtDni")).max;

    let valueApellido : string  = (<HTMLInputElement> document.getElementById("txtApellido")).value;
    let valueNombre : string = (<HTMLInputElement> document.getElementById("txtNombre")).value;

    let valueLegajo : string = (<HTMLInputElement> document.getElementById("txtLegajo")).value;
    let legajoMin : string = (<HTMLInputElement> document.getElementById("txtLegajo")).min;
    let legajoMax : string = (<HTMLInputElement> document.getElementById("txtLegajo")).max;

    let valueSueldo : string = (<HTMLInputElement> document.getElementById("txtSueldo")).value;
    let sueldoMin : string = (<HTMLInputElement> document.getElementById("txtSueldo")).min;
    let sueldoMax : number = obtenerSueldoMaximo(obtenerTurnoSeleccionado());

    let valueSexo : string = (<HTMLInputElement> document.getElementById("cboSexo")).value;

    AdministrarSpanError("spanDni", validarCamposVacios(valueDni));
    AdministrarSpanError("spanDni", validarRangoNumerico(parseInt(valueDni), parseInt(dniMin), parseInt(dniMax)));
    AdministrarSpanError("spanApellido", validarCamposVacios(valueApellido));
    AdministrarSpanError("spanNombre", validarCamposVacios(valueNombre));
    AdministrarSpanError("spanLegajo", validarCamposVacios(valueLegajo));
    AdministrarSpanError("spanSueldo", validarCamposVacios(valueSueldo));
    AdministrarSpanError("spanLegajo", validarRangoNumerico(parseInt(valueLegajo),parseInt(legajoMin),parseInt(legajoMax)));
    AdministrarSpanError("spanSueldo", validarRangoNumerico(parseInt(valueSueldo),parseInt(sueldoMin),sueldoMax));
    AdministrarSpanError("spanSexo", validarCombo(valueSexo, "---"));

    if(VerificarValidacionesIndex())
    {
        let form:FormData = new FormData(<HTMLFormElement> document.getElementById("form"))

        let xhr:XMLHttpRequest = new XMLHttpRequest();
        xhr.open('POST', "http://localhost/prog_lab_3/lab_3/TP1/ParteFinal/backend/administracion.php", true);
        xhr.send(form);

        xhr.onreadystatechange = ():void => {

            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    AltaSuccess(xhr.responseText);
                } else {
                        Fail(xhr.status);
                }
            }
        };

        // let params : string = `accion=${accion}&dni=${valueDni}&apellido=${valueApellido}&nombre=${valueNombre}&legajo=${valueLegajo}&sueldo=${valueSueldo}&sexo=${valueSexo}`;
        // ajax.Post("http://localhost/lab_3/TP1/ParteFinal/backend/administracion.php",
        //     AltaSuccess,
        //     params,
        //     Fail);
    }
}

function validarCamposVacios(value : string) : boolean
{
    let ret = false;

    if(value != "")
        ret = true;

    return ret;
}

function validarRangoNumerico(value : number, min : number, max : number) : boolean
{
    let ret = false;

    if(value <= max  && value >= min)
        ret = true;

    return ret;
}

function validarCombo(value : string, notValue : string) : boolean
{
    let ret = false;

    if(value != notValue)
        ret = true;

    return ret;
}

function obtenerTurnoSeleccionado() : string
{
    let ret : string = "";
    let turno = document.getElementsByName("rdoTurno");

    for(let i = 0; i < turno.length; i++)
    {
        if((<HTMLInputElement> turno[i]).checked)
        {
            ret = (<HTMLInputElement> turno[i]).value;
            break;
        }
    }
    return ret;
}

function obtenerSueldoMaximo(turno : string) : number
{
    let ret : number = 0;
    switch(turno)
    {
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

function AdministrarValidacionesLogin():void
{
    let valueDni : string = (<HTMLInputElement> document.getElementById("txtDni")).value;
    let dniMin : string = (<HTMLInputElement> document.getElementById("txtDni")).min;
    let dniMax : string = (<HTMLInputElement> document.getElementById("txtDni")).max;

    let valueApellido : string  = (<HTMLInputElement> document.getElementById("txtApellido")).value;

    AdministrarSpanError("spanDni", validarCamposVacios(valueDni));
    AdministrarSpanError("spanDni", validarRangoNumerico(parseInt(valueDni), parseInt(dniMin), parseInt(dniMax)));
    AdministrarSpanError("spanApellido", validarCamposVacios(valueApellido));

    if(VerificarValidacionesLogin())
    {
        let params : string = `dni=${valueDni}&apellido=${valueApellido}`;
        ajax.Post("http://localhost/prog_lab_3/lab_3/TP1/ParteFinal/backend/verificarUsuario.php",
            LoginSuccess,
            params,
            Fail);
    }
}

function AdministrarSpanError(string:string, boolean:boolean):void
{
    if(boolean != true)
    {
        (<HTMLInputElement> document.getElementById(string)).style.display = "block";
    }
    else
    {
        (<HTMLInputElement> document.getElementById(string)).style.display = "none";
    }
}

function VerificarValidacionesLogin():boolean
{
    let ret : boolean = true;

    if((<HTMLInputElement> document.getElementById("spanApellido")).style.display == "block"
        || (<HTMLInputElement> document.getElementById("spanDni")).style.display == "block")
        {
            ret = false;
        }
        return ret;
}

function VerificarValidacionesIndex():boolean
{
    let ret : boolean = true;

    if((<HTMLInputElement> document.getElementById("spanApellido")).style.display == "block"
        || (<HTMLInputElement> document.getElementById("spanDni")).style.display == "block"
        || (<HTMLInputElement> document.getElementById("spanNombre")).style.display == "block"
        || (<HTMLInputElement> document.getElementById("spanSexo")).style.display == "block"
        || (<HTMLInputElement> document.getElementById("spanLegajo")).style.display == "block"
        || (<HTMLInputElement> document.getElementById("spanSueldo")).style.display == "block"
        || (<HTMLInputElement> document.getElementById("archivo")).files?.length == 0)
        {
            ret = false;
        }
        return ret;
}


//Agrego esto para poder hacer las cosas con ajax
function AdministrarModificar(dni : string, apellido:string, nombre:string, sexo:string, legajo:string, sueldo:string, turno:string):void
{
    (<HTMLInputElement> document.getElementById("accion")).value = 'modificar';
    
    (<HTMLInputElement> document.getElementById("txtDni")).value = dni;
    (<HTMLInputElement> document.getElementById("txtDni")).readOnly = true;
    (<HTMLInputElement> document.getElementById("txtApellido")).value = apellido;
    (<HTMLInputElement> document.getElementById("txtNombre")).value = nombre;
    (<HTMLInputElement> document.getElementById("txtLegajo")).value = legajo;
    (<HTMLInputElement> document.getElementById("txtLegajo")).readOnly = true;
    (<HTMLInputElement> document.getElementById("txtSueldo")).value = sueldo;
    (<HTMLInputElement> document.getElementById("cboSexo")).value = sexo;

    //(<HTMLInputElement> document.getElementById("Maniana")).checked = false;
    switch(turno)
    {
        case "Maniana":
                (<HTMLInputElement> document.getElementById("maniana")).checked = true;
            break;
        case "Tarde":
                (<HTMLInputElement> document.getElementById("tarde")).checked = true;
            break;
        case "Noche":
                (<HTMLInputElement> document.getElementById("noche")).checked = true;
            break;
    }
}
function AdministrarEliminar(legajo:number)
{
    if(!confirm("Desea eliminar al empleado seleccionado? legajo: "+legajo))
        return;
    

    let parametro:string = `accion=eliminar&legajo=${legajo}`;

    ajax.Post("http://localhost/prog_lab_3/lab_3/TP1/ParteFinal/backend/eliminar.php",
                DeleteSuccess,
                parametro,
                Fail)
}

function MostrarLista():void {

    let parametros:string = `accion=mostrar`;

    ajax.Post("http://localhost/prog_lab_3/lab_3/TP1/ParteFinal/backend/mostrar.php", 
                MostrarListaSuccess, 
                parametros, 
                Fail);            
}

function MostrarListaSuccess(lista:string):void {
    console.clear();
    console.log(lista);
    (<HTMLDivElement>document.getElementById("divLista")).innerHTML = lista;
}

function DeleteSuccess(retorno:string):void {
    console.clear();
    console.log(retorno);
    alert(retorno);
    MostrarLista();
}

function LoginSuccess(retorno:string){
    console.clear();
    console.log(retorno);
    alert(retorno);
    if(retorno != "Datos invalidos")
    window.location.href = "http://localhost/prog_lab_3/lab_3/TP1/ParteFinal/index.php";
}

function AltaSuccess(retorno:string)
{
    console.clear();
    console.log();
    alert(retorno);
    (<HTMLInputElement> document.getElementById("btnLimpiar")).click();
    MostrarLista();
}

function Fail(retorno:string|number):void {
    console.clear();
    console.log(retorno);
    alert(retorno);
}
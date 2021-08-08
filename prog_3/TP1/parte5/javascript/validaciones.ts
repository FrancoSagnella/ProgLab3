function AdministrarValidaciones(e : Event): void 
{
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

    if(!VerificarValidacionesIndex())
        e.preventDefault();
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

function AdministrarValidacionesLogin(e:Event):void
{
    let valueDni : string = (<HTMLInputElement> document.getElementById("txtDni")).value;
    let dniMin : string = (<HTMLInputElement> document.getElementById("txtDni")).min;
    let dniMax : string = (<HTMLInputElement> document.getElementById("txtDni")).max;

    let valueApellido : string  = (<HTMLInputElement> document.getElementById("txtApellido")).value;

    AdministrarSpanError("spanDni", validarCamposVacios(valueDni));
    AdministrarSpanError("spanDni", validarRangoNumerico(parseInt(valueDni), parseInt(dniMin), parseInt(dniMax)));
    AdministrarSpanError("spanApellido", validarCamposVacios(valueApellido));

    if(!VerificarValidacionesLogin())
        e.preventDefault();
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

function AdministrarModificar(dni : string):void
{
    (<HTMLInputElement> document.getElementById("hiddenMod")).value = dni;
    (<HTMLFormElement> document.getElementById("formMod")).submit();
}
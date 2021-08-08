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

    if(!validarCamposVacios(valueDni))
    {
        console.log("El campo de DNI esta vacio");
        alert("El campo DNI esta vacio");
        e.preventDefault();
    }
    if(!validarCamposVacios(valueApellido))
    {
        console.log("El campo de Apellido esta vacio");
        alert("El campo Apellido esta vacio");
        e.preventDefault();
    }
    if(!validarCamposVacios(valueNombre))
    {
        console.log("El campo de Nombre esta vacio");
        alert("El campo Nombre esta vacio");
        e.preventDefault();
    }
    if(!validarCamposVacios(valueLegajo))
    {
        console.log("El campo de Legajo esta vacio");
        alert("El campo Legajo esta vacio");
        e.preventDefault();
    }
    if(!validarCamposVacios(valueSueldo))
    {
        console.log("El campo de Sueldo esta vacio");
        alert("El campo Sueldo esta vacio");
        e.preventDefault();
    }

    if(!validarRangoNumerico(parseInt(valueDni),parseInt(dniMin),parseInt(dniMax)))
    {
        console.log("El rango numerico del DNI es incorrecto, tiene que ser un valor entre 1000000 y 55000000");
        alert("El rango numerico del DNI es incorrecto, tiene que ser un valor entre 1000000 y 55000000");
        e.preventDefault();
    }
    if(!validarRangoNumerico(parseInt(valueLegajo),parseInt(legajoMin),parseInt(legajoMax)))
    {
        console.log("El rango numerico del Legajo es incorrecto, tiene que ser un valor entre 100 y 550");
        alert("El rango numerico del Legajo es incorrecto, tiene que ser un valor entre 100 y 550");
        e.preventDefault();
    }
    if(!validarRangoNumerico(parseInt(valueSueldo),parseInt(sueldoMin),sueldoMax))
    {
        console.log("El rango numerico del Sueldo es incorrecto, tiene que ser un valor entre 8000 y"+sueldoMax);
        alert("El rango numerico del Sueldo es incorrecto, tiene que ser un valor entre 8000 y"+sueldoMax);
        e.preventDefault();
    }
    
    if(!validarCombo(valueSexo, "---"))
    {
        console.log("El campo de sexo debe tener seleccionado alguna de las casillas de Masculino o Femenino");
        alert("El campo de sexo debe tener seleccionado alguna de las casillas de Masculino o Femenino");
        e.preventDefault();
    }

    /*if(valido == true)
    {
        (<HTMLFormElement> document.getElementById("form")).submit();
    }
    else
    {
        alert("Complete correctamente todos los campos antes de enviar");
    }*/
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
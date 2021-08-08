
 function ValidadCamposVacios (verificar :string): boolean { 
    let validar : boolean=false;
    //verificar=verificar;
    if(verificar.trim()!="" && verificar!=null )
    {
        validar=true;
    }

     return validar;
}
 function ValidarRangoNumerico(valor:number, min:number, max:number):boolean {
    let validar:boolean=false;

    if(valor>=min && valor<=max)
    {
        validar=true;
    }
    return validar;
}
 function ValidarCombo(valor:string , valorContrario:string):boolean {
    let validar:boolean=false;

    if(valor != valorContrario)
    {
        validar=true;
      //  alert(valorContrario + valor);
    }
    return validar;
}
 function ObtenerTurnoSeleccionado():string {
   let turno = document.getElementsByName("rdoTurno");
   let retorno: string = "";
   for(let i=0;turno.length;i++)
   {
       if( (<HTMLInputElement> turno[i]).checked )
       {
            retorno=(<HTMLInputElement> turno[i]).value;
            break;
       }
   }
   return retorno;
}
 function ObtenerSueldoMaximo(turno:string):number {
    let sueldoMax:number=0;
    
    switch (turno) {
        case "mañana":
            sueldoMax=20000;
            break;
        case "tarde":
            sueldoMax=18500;
            break;
        case "noche":
            sueldoMax=25000;
            break;
        default:
            sueldoMax=-1;
            break;
    }
    return sueldoMax;
}
let meses : string[] = ["enero", "febrero", "marzo", 
                        "abril", "mayo", "junio", "julio", 
                        "agosto", "septiembre", "octubre", "noviembre", "diciembre"];

MostrarMeses(meses);

function MostrarMeses(array : string[]) : void{
    for(let i = 0; i <= 11; i++){
        console.log("Mes: "+array[i]+" Numero: "+[i+1]);
    }
}
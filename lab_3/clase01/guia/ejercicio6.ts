mostrarPotencia(2);
mostrarPotencia(5);


function mostrarPotencia(num: number):void{
    console.log(cuboDeUnNumero(num));
}

function cuboDeUnNumero(num: number): number{
    return Math.pow(num, 3);
}
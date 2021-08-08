mostrarPrimos(20);

function mostrarPrimos(cant: number): void 
{
    let cont: number = 0;
    let i: number = 0;

    while (cont < cant) 
    {
        if(esPrimo(i))
        {
            console.log(i+" Es un numero primo");
            cont++;
        }
        i++;
    }
}

function esPrimo(num: number): boolean
{
    let retorno: boolean = false;
    if(num > 1)
    {
        retorno = true;
        for(let i: number = 2; i < num; i++)
        {
            if(num%i == 0)
            {
                retorno = false;
                break;
            }
        }
    }
    return retorno;
}
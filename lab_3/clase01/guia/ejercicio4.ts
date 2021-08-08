parImpar(4);
parImpar(47);

function parImpar(num: number): void {
    let aux = num%2;
    if(aux == 0){
        console.log("el numero "+num+" es par");
    }
    else {
        console.log("el numero "+num+" es impar");
    }
}
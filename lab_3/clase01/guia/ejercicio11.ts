ejercicio11("La ruta nos aporto otro paso natural");

function ejercicio11(cadena: string): void{

    let sinEspacios: string = cadena.toLowerCase().split(" ").join("")
    let invertida: string = sinEspacios.split("").reverse().join("");

    if(sinEspacios == invertida){
        console.log("Es un polindromo: "+cadena);
    }
    else{
        console.log("No es un polindromo: "+cadena);
    }
    
}
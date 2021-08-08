console.log(factorial(4));
console.log(factorial(0));
console.log(factorial(3));
console.log(factorial(8));

function factorial(num: number): number{
    let acum: number = 1;
    while(num > 1){
        acum *= num;
        num--;
    }
    return acum;
}
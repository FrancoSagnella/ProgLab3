<?php

function esPar($num)
{   
    if($num % 2 == 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function esImpar($num)
{
    return !esPar(($num));
}

if(esPar(2))
    echo "Mande un numero par<br/>";

if(!esPar(3))
    echo "mande un numero impar y me devolvio false<br/>";

if(esImpar(3))
    echo "Mande un numero impar y me devolvio true<br/>";

if(!esImpar(2))
    echo "Le mande un numero par a la funcion de impar";
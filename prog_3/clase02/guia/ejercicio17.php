<?php

    function validarPalabra($palabra, $max)
    {
        $ret = 0;
        if(strlen($palabra) <= $max)
        {
            if($palabra === "recuperatorio" || $palabra === "parcial" || $palabra === "programacion")
            {
                $ret = 1;
            }
        }
        return $ret;
    }

    if(validarPalabra("recuperatorio", 13) == 1)
    {
        echo "La palabra estaba en el listado<br/>";
    }

    if(validarPalabra("perro", 13) == 0)
    {
        echo "La palabra no estaba en el listado<br/>";
    }

    if(validarPalabra("asdasdasd", 2) == 0)
    {
        echo "Aca la palabra es mas chica de lo permitido";
    }
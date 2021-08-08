<?php
    $array = array(1=>90, 30=>7, 'e'=>99, 'hola'=>'mundo');
    imprimirArrayAsociativo($array);

    function imprimirArrayAsociativo($array){
        foreach($array as $k => $value){
            echo "Clave: " . $k . " Elemento: " . $value . "<br>";
        }
    }
?>
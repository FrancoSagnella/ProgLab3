<?php

    $lapicera1 = crearLapicera("rojo", "marca1", 10, 20);
    $lapicera2 = crearLapicera("verde", "marca2", 15, 30);
    $lapicera3 = crearLapicera("negro", "marca1", 5, 25);

    imprimirArrayAsociativo($lapicera1);
    echo "<br>";
    imprimirArrayAsociativo($lapicera2);
    echo "<br>";
    imprimirArrayAsociativo($lapicera3);
    echo "<br>";

    function crearLapicera($color, $marca, $trazo, $precio){
        return array("color"=>$color, "marca"=>$marca, "trazo"=>$trazo, "precio"=>$precio);
    }
    function imprimirArrayAsociativo($array){
        foreach($array as $k => $value){
            echo "Clave: " . $k . " Elemento: " . $value . "<br>";
        }
    }
?>

<?php
    //$fecha = date("l j");
    $fecha = date("d/m/Y h:i:s A");
    $mes = date("n");
    echo $fecha . "<br>";

    switch($mes){
        case 1:
        case 2:
        case 3:
            echo " Es verano";
            break;
        case 4:
        case 5:
        case 6:
            echo " Es otoño";
            break;
        case 7:
        case 8:
        case 9:
            echo " Es invierno"; 
            break;
        case 10:
        case 11:
        case 12:
            echo " Es primavera"; 
            break;
    }
?>
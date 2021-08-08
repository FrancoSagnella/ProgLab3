<?php
    $a = 4;
    $b = 1;
    $c = 5;

    if($a < $b && $a > $c || $a > $b && $a < $c){
        echo "El valor medio es: " . $a;
    }
    else if($b < $a && $b > $c || $b > $a && $b < $c){
        echo "El valor medio es: " . $b;
    }
    else if($c < $a && $c > $b || $c > $a && $c < $b){
        echo "El valor medio es: " . $c;
    }
    else{
        echo "No hay valor medio";
    }
?>
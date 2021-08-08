<?php
    $suma = 0;
    $i = 1;

    for(;$suma <= 1000; $i++){
        $suma += $i;
        echo $suma . "<br>";
    }

    echo "Total de numeros sumados: " . $i;
?>
<?php
    $array = array(rand(1, 10), rand(1, 10), rand(1, 10), rand(1, 10), rand(1, 10));
    $acum = 0;
    $prom;

    var_dump($array) . "<br>";

    foreach($array as $valor){
        $acum+=$valor;
    }

    $prom = $acum/count($array);
    echo $prom  . "<br>";

    if($prom < 6){
        echo "El promedio es menor a 6";
    }
    else if($prom == 6){
        echo "El promedio es igual 6";
    }
    else{
        echo "El promedio es mayor a 6";
    }
?>

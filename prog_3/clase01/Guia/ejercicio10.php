<?php
    $array = array();
    $cont = 1;

    while(count($array) < 10){
        if($cont%2 != 0){
            $array[] = $cont;
        }
        $cont++;
    }

    var_dump($array);
    echo "<br>";

    for($i = 0; $i < count($array); $i++){
        echo $array[$i] . "<br>";
    }

    foreach($array as $value){
        echo $value . "<br>";
    }

    $i = 0;
    while($i < count($array)){
        echo $array[$i] . "<br>";
        $i++;
    }
?>
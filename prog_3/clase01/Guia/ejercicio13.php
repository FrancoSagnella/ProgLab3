<?php
    $array1 = array();
    array_push($array1 , "Perro", "Gato", "Ratón", "Araña", "Mosca");

    $array2 = array();
    array_push($array2, "1986", "1996", "2015", "78", "86");

    $array3 = array();
    array_push($array3, "php", "mysql", "html5", "typescript", "ajax");

    $fusion = array_merge($array1, $array2, $array3);

    var_dump($array1);
    echo "<br>";
    var_dump($array2);
    echo "<br>";
    var_dump($array3);
    echo "<br>";
    var_dump($fusion);
?>
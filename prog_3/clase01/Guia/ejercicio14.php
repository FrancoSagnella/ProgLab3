<?php
        $array1 = array();
        array_push($array1 , "Perro", "Gato", "Ratón", "Araña", "Mosca");
    
        $array2 = array();
        array_push($array2, "1986", "1996", "2015", "78", "86");
    
        $array3 = array();
        array_push($array3, "php", "mysql", "html5", "typescript", "ajax");

        $arrayDeArraysIndex = array($array1, $array2, $array3);
        var_dump($arrayDeArraysIndex);
        echo "<br>";

        $arrayDeArraysAsoc = array("index1"=>$array1, "index2"=>$array2, "index3"=>$array3);
        var_dump($arrayDeArraysAsoc);
        echo "<br>";
?>
<?php

    function invertirArray($array)
    {
        return array_reverse($array);
    }

    $array = array('H', 'O', 'L', 'A');

    var_dump($array);

    echo "<br/>";

    var_dump(invertirArray($array));
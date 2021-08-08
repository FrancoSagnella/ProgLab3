<?php
    require_once "clases/Cocinero.php";

    $lista = Cocinero::TraerTodos();
    $cadena = "";
    foreach($lista as $cocinero)
    {
        $cadena .= $cocinero->toJSON() . "</br>";
    }

    echo $cadena;
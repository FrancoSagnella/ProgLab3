<?php
    require_once "./clases/cocinero.php";


    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se pudo leer nada del archivo';

    $cocinero_array = Cocinero::TraerTodos();

    if(isset($cocinero_array[0]))
    {

        $ret->exito = true;
        $ret->mensaje = 'listado leido';
        $cocinero_array_json = array();


        foreach($cocinero_array as $cocinero)
        {
            array_push($cocinero_array_json, json_decode($cocinero->ToJson()));
        }
        $ret->cocineros = $cocinero_array_json;
    }

    echo json_encode($ret);
<?php
//lo primero que hago es agregar los archivos
    require_once "./clases/ufologo.php";

    //Como no recibo ningun parametro por get o post, no hace falta que valide nada de eso

    //tengo que leer el archivo y retornar su contenido
    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se pudo leer nada del archivo';

    $ufologos_array = Ufologo::TraerTodos();

    if(isset($ufologos_array[0]))
    {
        //var_dump($ufologos_array);
        $ret->exito = true;
        $ret->mensaje = 'listado leido';
        $ufologos_array_json = array();

        //recorro el array 
        foreach($ufologos_array as $ufologo)
        {
            //cada ufologo, lo guardo en otro array en vez de como objeto ufologo, como un array
            //esto porque como los atributos son privados, el json encode no me dejaria hacerlo despues
            //el tojson me devuelve un string json que, al decodearlo se hace un strng, con los mismos datos que el objeto ufologo
            array_push($ufologos_array_json, json_decode($ufologo->ToJson()));
        }
        //ese array de arrays con los dtos de los ufologos lo guardo en un parametro del retorno
        $ret->ufologos = $ufologos_array_json;
    }
    //es importante que los arrays de ufologos no este encodeados, siempre tienen que estar en estado de array, no de json
    //entonces cuando encodeo el retrno final queda todo bien
    echo json_encode($ret);
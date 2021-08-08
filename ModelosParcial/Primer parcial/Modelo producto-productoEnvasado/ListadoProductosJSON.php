<?php
//lo primero que hago es agregar los archivos
    require_once "./clases/producto.php";

    //Como no recibo ningun parametro por get o post, no hace falta que valide nada de eso

    //tengo que leer el archivo y retornar su contenido
    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se pudo leer nada del archivo';

    $productos_array = Producto::TraerJSON();

    if(isset($productos_array[0]))
    {
        //var_dump($ufologos_array);
        $ret->exito = true;
        $ret->mensaje = 'listado leido';
        $productos_array_json = array();

        //recorro el array 
        foreach($productos_array as $producto)
        {
            //cada ufologo, lo guardo en otro array en vez de como objeto ufologo, como un array
            //esto porque como los atributos son privados, el json encode no me dejaria hacerlo despues
            //el tojson me devuelve un string json que, al decodearlo se hace un strng, con los mismos datos que el objeto ufologo
            array_push($productos_array_json, json_decode($producto->ToJson()));
        }
        //ese array de arrays con los dtos de los ufologos lo guardo en un parametro del retorno
        $ret->productos = $productos_array_json;
    }
    //es importante que los arrays de ufologos no este encodeados, siempre tienen que estar en estado de array, no de json
    //entonces cuando encodeo el retrno final queda todo bien
    echo json_encode($ret);
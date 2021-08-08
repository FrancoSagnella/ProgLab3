<?php

    require_once './clases/receta.php';

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
    $ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : false;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'no se recibieron los parametros';

    if($nombre !== false && $ingredientes !== false && $tipo !== false)
    {
        $ret->mensaje = 'no se pudo agregar el producto';

        $receta = new Receta(null, $nombre, $ingredientes, $tipo);
        if($receta->Agregar())
        {
            $ret->exito = true;
            $ret->mensaje = 'receta agregado con exito';
        }
    }

    echo json_encode($ret);
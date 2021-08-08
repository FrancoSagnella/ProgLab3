<?php

    require_once './clases/ovni.php';

    $json_ovni = isset($_POST['json_ovni']) ? $_POST['json_ovni'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'no se recibieron los parametros';

    if($json_ovni !== false)
    {
        $ret->mensaje = 'el json no tenia los parametros';
        $json_ovni = json_decode($json_ovni);

        if(isset($json_ovni->tipo) && isset($json_ovni->velocidad) && isset($json_ovni->planetaOrigen))
        {
            $ret->mensaje = 'no se pudo agregar el ovni';

            $ovni = new Ovni($json_ovni->tipo, $json_ovni->velocidad, $json_ovni->planetaOrigen);
            if($ovni->Agregar())
            {
                $ret->exito = true;
                $ret->mensaje = 'ovni agregado con exito';
            }
        }
    }

    echo json_encode($ret);
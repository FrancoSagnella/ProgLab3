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
            $ret->mensaje = 'El ovni no existe en la base de datos';

            $ovni = new Ovni($json_ovni->tipo, $json_ovni->velocidad, $json_ovni->planetaOrigen, isset($json_ovni->pathFoto) ? $json_ovni->pathFoto : null);
            $ovnis_array = $ovni->Traer();

            foreach($ovnis_array as $aux)
            {
                if($aux == $ovni)
                {
                    $ret->exito = true;
                    $ret->mensaje = 'El ovni existe en la base de datos';
                }
            }
            
        }
    }

    echo json_encode($ret);
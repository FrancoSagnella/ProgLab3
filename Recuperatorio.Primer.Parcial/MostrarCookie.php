<?php
    require_once "./clases/cocinero.php";

    $especialidad = isset($_GET['especialidad']) ? $_GET['especialidad'] : false;
    $email = isset($_GET['email']) ? $_GET['email'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron los parametros';

    if($especialidad !== false && $email !== false)
    {
        $ret->mensaje = 'No existe una cookie con ese nombre';

        $email = str_replace('.', '_', $email);
        if(isset($_COOKIE[$email."_".$especialidad]))
        {
            $ret->exito = true;
            $ret->mensaje = $_COOKIE[$email."_".$especialidad];
        }
    }

    echo json_encode($ret);
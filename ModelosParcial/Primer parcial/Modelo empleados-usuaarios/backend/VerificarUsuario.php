<?php
    require_once "./clases/usuario.php";

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = "No se recibio POST";

    $user_json = isset($_POST['usuario_json']) ? $_POST['usuario_json'] : false;

    if($user_json != false)
    {
        if(($user = Usuario::TraerUno($user_json)) != false)
        {
            //var_dump($user);
            $ret->exito = true;
            $ret->mensaje = "Se encontro el usuario";
        }
        else{
            $ret->mensaje = "No se encontro el usuario";
        }
    }

    echo json_encode($ret);
<?php
    require_once "./clases/usuario.php";

    $user_json = isset($_POST['usuario_json']) ? json_decode($_POST['usuario_json']) : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = "No se recibio POST";

    if($user_json != false)
    {
        $user = new Usuario($user_json->id, $user_json->nombre, $user_json->correo, $user_json->clave, $user_json->id_perfil);
        if($user->Modificar())
        {
            $ret->exito = true;
            $ret->mensaje= "Usuario modificado";
        }
        else{
            $ret->mensaje = "No se pudo modificar el usuario";
        }
    }

    echo json_encode($ret);
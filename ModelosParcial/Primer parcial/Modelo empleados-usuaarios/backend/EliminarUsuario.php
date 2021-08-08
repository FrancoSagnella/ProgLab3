<?php
    require_once "./clases/usuario.php";

    $id = isset($_POST['id']) ? $_POST['id'] : false;
    $accion = isset($_POST['accion']) ? $_POST['accion'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = "No se recibio POST";

    if($id != false && $accion != false)
    {
        $ret->mensaje = "El parametro accion no esta establecido en borrar";
        if($accion === "borrar"){
            if(Usuario::Eliminar($id)){
                $ret->exito = true;
                $ret->mensaje = "Usuario eliminado con exito";
            }
            else{
                $ret->mensaje = "No se pudo eliminar el usuario";
            }
        }
    }

    echo json_encode($ret);
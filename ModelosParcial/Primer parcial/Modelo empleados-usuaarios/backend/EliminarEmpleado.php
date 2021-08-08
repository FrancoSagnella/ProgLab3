<?php
    require_once "./clases/empleado.php";

    $id = isset($_POST['id']) ? $_POST['id'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = "No se recibio POST";

    if($id != false)
    {
        $ret->mensaje = "El empleado no estaba en la base de datos";
        if(($empAux = Empleado::TraerUnoId($id)) != false)
        {
            if(Empleado::Eliminar($id)){
                //Si lo pudo borrar sin problemas, borro la foto que tenia
                unlink($empAux->foto);
                $ret->exito = true;
                $ret->mensaje = "Empleado eliminado con exito";
            }
            else{
                $ret->mensaje = "No se pudo eliminar el empleado";
            }
        }
        
    }

    echo json_encode($ret);
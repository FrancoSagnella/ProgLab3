<?php
    require_once "./clases/empleado.php";

    $emp_json = isset($_POST['empleado_json']) ? json_decode($_POST['empleado_json']) : false;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = "No se recibio POST";

    if($emp_json != false && $foto != false)
    {
        $ret->mensaje = "El empleado no existia en la base de datos";
        if(($empAux = Empleado::TraerUnoId($emp_json->id)) != false)
        {
            $emp = new Empleado($emp_json->id, $emp_json->nombre, $emp_json->correo, $emp_json->clave, $emp_json->id_perfil, null, $emp_json->foto, $emp_json->sueldo);
            if($emp->Modificar())
            {
                //Si se pudo modificar bien, muevo la foto nueva a donde debo, y borro la foto vieja
                move_uploaded_file($foto['tmp_name'], $emp->foto);
                unlink($empAux->foto);
                $ret->exito = true;
                $ret->mensaje= "Empleado modificado";
            }
            else{
                $ret->mensaje = "No se pudo modificar el empleado";
            }
        }
        
    }

    echo json_encode($ret);
<?php
    require_once "./clases/empleado.php";

    $correo = isset($_POST['correo']) ? $_POST['correo'] : false;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : false;
    $nombre= isset($_POST['nombre']) ? $_POST['nombre'] : false;
    $id_perfil = isset($_POST['id_perfil']) ? $_POST['id_perfil'] : false;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;
    $sueldo= isset($_POST['sueldo']) ? $_POST['sueldo'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = "No se recibieron los parametros necesarios POST";

    if($correo != false && $clave != false && $nombre != false && $id_perfil != false && $foto != false && $sueldo != false)
    {  
        if(Empleado::TraerUno(json_encode(array('correo' => $correo, 'clave' => $clave))) == false)
        {
            $pathFoto = Empleado::GuardarFoto($nombre, $foto);
            $emp = new Empleado(null, $nombre, $correo, $clave, $id_perfil, null, $pathFoto, $sueldo);
            if(!$emp->Agregar())
            {
                $ret->mensaje = "Error al agregar el empleado";
            }
            else{
                $ret->exito = true;
                $ret->mensaje = "Empleado agregado correctamente";
            }
        }
        else{
            $ret->mensaje = "El empleado ya existe en la base de datos";
        }
    }

    echo json_encode($ret);
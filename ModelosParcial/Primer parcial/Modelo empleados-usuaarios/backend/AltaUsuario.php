<?php
    require_once "./clases/usuario.php";

    $correo = isset($_POST['correo']) ? $_POST['correo'] : false;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : false;
    $nombre= isset($_POST['nombre']) ? $_POST['nombre'] : false;
    $id_perfil = isset($_POST['id_perfil']) ? $_POST['id_perfil'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = "No se recibieron los parametros necesarios POST";

    if($correo != false && $clave != false && $nombre != false && $id_perfil != false)
    {  
        if(Usuario::TraerUno(json_encode(array('correo' => $correo, 'clave' => $clave))) == false)
        {
            $user = new Usuario(null, $nombre, $correo, $clave, $id_perfil);
            if(!$user->Agregar())
            {
                $ret->mensaje = "Error al agregar el usuario";
            }
            else{
                $ret->exito = true;
                $ret->mensaje = "usuario agregado correctamente";
            }
        }
        else{
            $ret->mensaje = "El usuario ya existe en la base de datos";
        }
    }

    echo json_encode($ret);
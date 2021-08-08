<?php
    require_once "./clases/usuario.php";

    $correo = isset($_POST['correo']) ? $_POST['correo'] : false;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : false;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;

    if($correo != false && $clave != false && $nombre != false)
    {
        $user = new Usuario(null, $nombre, $correo, $clave);
        $retorno = json_decode($user->GuardarEnArchivo());
        echo $retorno->mensaje;
    }
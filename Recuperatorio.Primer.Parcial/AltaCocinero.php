<?php
    require_once "./clases/cocinero.php";

    $especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : false;
    $email = isset($_POST['email']) ? $_POST['email'] : false;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron los parametros';

    if($especialidad !== false && $email !== false && $clave !== false)
    {
        $cocinero = new Cocinero($especialidad, $email, $clave);
        $ret = json_decode($producto->GuardarEnArchivo());
    }

    echo json_encode($ret);
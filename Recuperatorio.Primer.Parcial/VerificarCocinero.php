<?php
    require_once "./clases/cocinero.php";

    $email = isset($_POST['email']) ? $_POST['email'] : false;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron los parametros';

    $especialidad = null;
    if($email !== false && $clave !== false)
    {
        $cocinero = new Cocinero("",$email, $clave);
        $ret = json_decode(Cocinero::VerificarExistencia($cocinero));

        if($ret->exito)
        {
            $especialidad = Cocinero::ObtenerEspecialidad($cocinero);
            setcookie($email."_".$especialidad, date("d-m-y") . " - " . date("H:i:s") . "  " . $ret->mensaje);
        }
    }

    echo json_encode($ret);

<?php
//lo primero que hago es agregar los archivos
    require_once "./clases/ufologo.php";

    //despues guardo lo que recibo por post en variables, si no recibi nada guardo falses
    $clave = isset($_POST['clave']) ? $_POST['clave'] : false;
    $legajo = isset($_POST['legajo']) ? $_POST['legajo'] : false;

    //creo para retornar
    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron los parametros';

    //aca adentro hago las funcionalidades que necesite
    if($clave != false && $legajo != false)
    {
        $ret = json_decode(Ufologo::VerificarExistencia(new Ufologo(null, $legajo, $clave)));

        if($ret->exito === true)
        {
            //creo una cookie, el nombre es el legajo, el valor es la fecha actual + mensaje que retorno verificarExistencia
            setcookie($legajo, date("d-m-y") . " - " . date("H:i:s") . $ret->mensaje);
            $ret->mensaje = 'Cookie guardada con exito';

            header('Location: ./ListadoUfologos.php');
        }
    }

    echo json_encode($ret);
<?php
//lo primero que hago es agregar los archivos
    require_once "./clases/ufologo.php";

    //despues guardo lo que recibo por post en variables, si no recibi nada guardo false
    $pais = isset($_POST['pais']) ? $_POST['pais'] : false;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : false;
    $legajo = isset($_POST['legajo']) ? $_POST['legajo'] : false;

    //creo para retornar
    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron los parametros';

    //aca adentro hago las funcionalidades que necesite
    if($pais != false && $clave != false && $legajo != false)
    {
        $ufologo = new Ufologo($pais, $legajo, $clave);
        //el metodo me devuelve el json, yo lo decodeo para tener el objeto
        $ret = json_decode($ufologo->GuardarEnArchivo());
    }

    //retorno el objeto encodeandolo en json
    echo json_encode($ret);
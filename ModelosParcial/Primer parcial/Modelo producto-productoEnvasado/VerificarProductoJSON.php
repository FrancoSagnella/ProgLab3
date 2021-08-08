<?php
//lo primero que hago es agregar los archivos
    require_once "./clases/producto.php";

    //despues guardo lo que recibo por post en variables, si no recibi nada guardo falses
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : false;

    //creo para retornar
    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron los parametros';

    //aca adentro hago las funcionalidades que necesite
    if($nombre != false && $origen != false)
    {
        $ret = json_decode(Producto::VerificarProductoJSON(new Producto($nombre, $origen)));

        if($ret->existe === true)
        {
            //creo una cookie, el nombre es el legajo, el valor es la fecha actual + mensaje que retorno verificarExistencia
            setcookie($nombre . '_' . $origen, date("d-m-y") . " - " . date("H:i:s") . " " . $ret->mensaje);
        }
    }

    echo json_encode($ret);
<?php
//lo primero que hago es agregar los archivos
    require_once "./clases/producto.php";

    //despues guardo lo que recibo por post en variables, si no recibi nada guardo false
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : false;

    //creo para retornar
    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron los parametros';

    //aca adentro hago las funcionalidades que necesite
    if($nombre != false && $origen != false)
    {
        $producto = new Producto($nombre, $origen);
        //el metodo me devuelve el json, yo lo decodeo para tener el objeto
        $ret = json_decode($producto->GuardarJSON('./archivos/productos.json'));
    }

    //retorno el objeto encodeandolo en json
    echo json_encode($ret);
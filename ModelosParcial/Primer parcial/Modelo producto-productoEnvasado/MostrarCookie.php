<?php
//lo primero que hago es agregar los archivos
    require_once "./clases/producto.php";

    //despues guardo lo que recibo por post en variables, si no recibi nada guardo false
    $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : false;
    $origen = isset($_GET['origen']) ? $_GET['origen'] : false;

    //creo para retornar
    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron los parametros';

    //aca adentro hago las funcionalidades que necesite
    if($nombre !== false && $origen !== false)
    {
        $ret->mensaje = 'No existe una cookie con ese nombre';

        //la cookie se guarda en la variable cookie, que es un array, entonces el nombre de la cookie es su indice
        if(isset($_COOKIE[$nombre."_".$origen]))
        {
            //si existe, retorno true y el mensaje
            $ret->exito = true;
            //para sacar el contenido de la cookie solamente accedo al indice, como un array normal
            $ret->mensaje = $_COOKIE[$nombre."_".$origen];
        }
    }

    echo json_encode($ret);
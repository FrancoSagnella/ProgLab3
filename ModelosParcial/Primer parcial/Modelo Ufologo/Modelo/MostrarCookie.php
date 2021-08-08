<?php
//lo primero que hago es agregar los archivos
    require_once "./clases/ufologo.php";

    //despues guardo lo que recibo por post en variables, si no recibi nada guardo false
    $json_ufologo = isset($_GET['json_ufologo']) ? $_GET['json_ufologo'] : false;

    //creo para retornar
    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron los parametros';

    //aca adentro hago las funcionalidades que necesite
    if($json_ufologo != false )
    {
        $ret->mensaje = 'El json no contenia legajo';
        $json_ufologo = json_decode($json_ufologo);

        if(isset($json_ufologo->legajo))
        {
            $ret->mensaje = 'No existe una cookie con ese nombre';

            //la cookie se guarda en la variable cookie, que es un array, entonces el nombre de la cookie es su indice
            if(isset($_COOKIE[$json_ufologo->legajo]))
            {
                //si existe, retorno true y el mensaje
                $ret->exito = true;
                //para sacar el contenido de la cookie solamente accedo al indice, como un array normal
                $ret->mensaje = $_COOKIE[$json_ufologo->legajo];
            }
        }
    }

    echo json_encode($ret);
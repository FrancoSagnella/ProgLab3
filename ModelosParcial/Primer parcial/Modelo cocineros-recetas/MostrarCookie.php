<?php
    $ciudad = isset($_GET['especialidad']) ? $_GET['especialidad'] : NULL;
    $email = isset($_GET['email']) ? $_GET['email'] : NULL;
    
    $retorno = new stdClass();
    if(isset($_COOKIE[$email."_"])){
        $retorno->exito = true;
        $retorno->mensaje = $_COOKIE[$email."_"];
    }
    else{
        $retorno->exito = false;
        $retorno->mensaje = "No existe una cookie con ese nombre";
    }

    echo json_encode($retorno);
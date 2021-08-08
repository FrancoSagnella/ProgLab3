<?php
    require_once "clases/Cocinero.php";
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
    $retorno = new stdClass();
    $cocinero = new Cocinero("",$email, $clave);
    $aux=Cocinero::VerificarExistencia($cocinero);
    if($aux->exito){
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $date = date("d-m-y") . " - " . date("H:i:s");
        setcookie($email."_"."",$date.$aux->mensaje);
        $retorno->exito=true;
        $retorno->mensaje=$aux->mensaje;
        echo json_encode($retorno);
    }
    else{
        
        $retorno->exito=false;
        $retorno->mensaje="El cocinero no existe";
        echo json_encode($retorno);
    }
<?php
    require_once "./clases/Recetas.php";

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : NULL;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;

    $json = new stdClass();
    
    $receta = new Recetas(null,$nombre, $ingredientes, $tipo);
    
    if($receta->Agregar())
    {
        $json->exito = true;
        $json->mensaje = "Se agrego correctamente";
        echo json_encode($json);
    }
    else
    {
        $json->exito = false;
        $json->mensaje = "No se pudo agregar";
        echo json_encode($json);
    }
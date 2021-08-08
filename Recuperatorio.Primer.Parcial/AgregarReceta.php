<?php

    require_once "./clases/receta.php";

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
    $ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : false;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : false;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = "No se recibieron los parametros requeridos";

    if($nombre != false && $ingredientes != false && $tipo != false && $foto != false)
    {
        $ret->mensaje = 'El receta ya existe en la base de datos';

        $pathFoto = Receta::GenerarNombreFoto($foto, $nombre, $tipo);
        $receta = new Receta(null, $nombre, $ingredientes, $tipo, $pathFoto);

        if(!$receta->Existe(Receta::Traer()))
        {
            $ret->mensaje = 'No se pudo agregar la receta a la base de datos';

            if($receta->Agregar())
            {
                $ret->exito = true;
                $ret->mensaje = 'receta agregado con exito';

                if($pathFoto !== null)
                {
                    move_uploaded_file($foto["tmp_name"], "./recetas/imagenes/" . $pathFoto);
                }
            }
        }
    }

    echo json_encode($ret);
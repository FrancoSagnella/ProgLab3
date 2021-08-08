<?php
    require_once "./clases/Recetas.php";

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;
    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

    $nombreFoto = $nombre . "." . $tipo. "." . date("Gis") . ".jpeg";

    $receta = new Recetas(null,$nombre,$ingredientes,$tipo,$nombreFoto);
    $ruta = "./recetas/imagenes/".$nombreFoto;
    $json = new stdClass();
    $json->exito = false;
    if ($receta->Existe($receta->Traer())) {
        $json->exito = false;
        $json->mensaje = "Ya esta esta receta";
        echo json_encode($json);
    }
    else
    {
        if(move_uploaded_file($_FILES["foto"]["tmp_name"],$ruta))
        {
            if($receta->Agregar()){
                $json->exito = true;
                $json->mensaje = "Se agrego correctamente";
                echo json_encode($json);
            }
            else{
                $json->mensaje = "No se pudo agregar";
                echo json_encode($json);
            }
        }
        else
        {
            $json->mensaje = "No se pudo agregar";
            echo json_encode($json);
        }
    }
        
    

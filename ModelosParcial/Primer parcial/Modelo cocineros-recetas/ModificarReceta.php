<?php
    require_once "clases/Recetas.php";
    $recetaJson = isset($_POST['receta_json']) ? $_POST['receta_json'] : NULL;
    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;
    

    $recetaJson=json_decode($recetaJson);

    $nombreFoto = $recetaJson->nombre . "." . $recetaJson->tipo. "." . "modificado". "." . date("Gis") . ".jpeg";
    $ruta = "./recetasModificadas/imagenes/".$nombreFoto;    
    $aux = new Recetas($recetaJson->id,$recetaJson->nombre,$recetaJson->ingredientes,$recetaJson->tipo,$recetaJson->pathFoto);
    
    $json = new stdClass();
    if ($aux->Modificar($aux->id)) {
        if(move_uploaded_file($_FILES["foto"]["tmp_name"],$ruta)){
            $json->exito = true;
            $json->mensaje = "Se modifico correctamente";
            //header('location:ListadoDeCiudades.php');
            echo json_encode($json);
        }
    }
    else
    {
        $json->exito = false;
        $json->mensaje = "No se pudo modificar"; 
        echo json_encode($json);
    }
?>
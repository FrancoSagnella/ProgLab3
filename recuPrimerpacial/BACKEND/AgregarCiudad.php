<?php
    require_once "./clases/Ciudad.php";

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $pais = isset($_POST['pais']) ? $_POST['pais'] : null;
    $poblacion = isset($_POST['poblacion']) ? (int)$_POST['poblacion'] : null;
    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

    $tipoArchivo = pathinfo($foto, PATHINFO_EXTENSION);

    $verificar=new stdClass();
    $verificar->mensaje="error al agregar";
    $verificar->exito=true;
    $nombreFoto= $nombre . "." . $pais . "." . date("Gis") . "." . $tipoArchivo;
    $ciudad=new Ciudad(null,$nombre,$poblacion,$pais,$nombreFoto);
    $lista=Ciudad::Traer();
    if($ciudad->Existe($lista))
    {
        $verificar->mensaje="ya existe";

    }
    else
    {
        $destino = "ciudades/imagenes/" . $nombreFoto;
    
        if($ciudad->Agregar())
        {
             move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

             
             $verificar->mensaje="la ciudad agregada con exito";
             $verificar->exito=true;
        }
        else{
         $verificar->mensaje="el producto no fue agregado";
        }
    }
    echo json_encode($verificar);    
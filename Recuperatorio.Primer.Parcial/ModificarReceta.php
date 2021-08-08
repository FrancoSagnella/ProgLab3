<?php

    require_once './clases/receta.php';

    $receta_json = isset($_POST['receta_json']) ? $_POST['receta_json'] : false;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'no se recibieron los parametros';

    if($receta_json !== false && $foto !== false)
    {
        $ret->mensaje = 'el json no tenia los parametros';
        $receta_json = json_decode($receta_json);

        if(isset($receta_json->id) && isset($receta_json->nombre) && isset($receta_json->ingredientes) && isset($receta_json->tipo) && isset($receta_json->pathFoto))
        {
            $ret->mensaje = 'La receta no existia en la base de datos';

            $pathFoto = Receta::GenerarNombreFoto($foto, $receta_json->nombre, $receta_json->tipo);
            $receta = new Receta($receta_json->id, $receta_json->nombre, $receta_json->ingredientes, $receta_json->tipo, $pathFoto);

            $recetasArray = Receta::Traer();

            if($receta->ExisteId($recetasArray))
            {
                $ret->mensaje = 'la receta no se pudo modificar';

                if($receta->Modificar())
                {
                    $ret->exito = true;
                    $ret->mensaje = 'receta modificada con exito';

                    move_uploaded_file($foto["tmp_name"],"./recetas/imagenes/" . $pathFoto);

                    foreach($recetasArray as $aux)
                    {
                        if($aux->id = $receta->id)
                        {
                            if($aux->pathFoto !== null)
                            {
                                Receta::MoverFoto($aux->pathFoto, $aux, 'modificado');
                            }
                        }
                    }
                }
            }
        }
    }

    echo json_encode($ret);
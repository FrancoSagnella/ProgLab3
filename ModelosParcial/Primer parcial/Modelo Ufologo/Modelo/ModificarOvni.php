<?php

    require_once './clases/ovni.php';

    $json_ovni = isset($_POST['json_ovni']) ? $_POST['json_ovni'] : false;
    $id = isset($_POST['id']) ? $_POST['id'] : false;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'no se recibieron los parametros';

    if($json_ovni !== false && $foto !== false && $id !== false)
    {
        $ret->mensaje = 'el json no tenia los parametros';
        $json_ovni = json_decode($json_ovni);

        if(isset($json_ovni->tipo) && isset($json_ovni->velocidad) && isset($json_ovni->planetaOrigen))
        {
            $ret->mensaje = 'El ovni no existia en la base de datos';

            //creo el objeto, para eso primero genero el nombre de la foto, para guardarlo en su parametro
            $pathFoto = Ovni::GenerarNombreFoto($foto, $json_ovni->tipo, $json_ovni->planetaOrigen);
            $ovni = new Ovni($json_ovni->tipo, $json_ovni->velocidad, $json_ovni->planetaOrigen, $pathFoto);

            //el traer id me esta retornando el ovni con ese id o false
            $ovni_array = Ovni::TraerId($id);
            //si es diferente de false, quiere decir que lo encontro
            if($ovni_array !== false)
            {
                $ret->mensaje = 'el ovni no se pudo modificar';

                if($ovni->Modificar($id))
                {
                    $ret->exito = true;
                    $ret->mensaje = 'Ovni modificado con exito';

                    //guardo la foto nueva 
                    move_uploaded_file($foto["tmp_name"],"./ovnis/imagenes/" . $pathFoto);

                    //la foto vieja la muevo al directorio de borrados (si es que tenia)
                    if($ovni_array[0]->pathFoto !== null)
                    {   //usando un metodo que me mueve la foto, renombrandola
                        Ovni::MoverFoto($ovni_array[0]->pathFoto, $ovni_array[0], 'modificado');
                        //si la quiero mover sin renombrar, dejandole el nombre que tenia antes
                        //rename(chop("./ovnis/imagenes/" . $ovni_array[0]->pathFoto), chop("./ovnisModificados/" . $ovni_array[0]->pathFoto));
                    }

                    header('Location: ./Listado.php');
                }
            }
        }
    }

    echo json_encode($ret);
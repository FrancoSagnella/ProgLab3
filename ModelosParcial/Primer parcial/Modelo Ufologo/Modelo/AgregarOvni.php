<?php

    require_once './clases/ovni.php';

    $json_ovni = isset($_POST['json_ovni']) ? $_POST['json_ovni'] : false;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'no se recibieron los parametros';

    if($json_ovni !== false && $foto !== false)
    {
        $ret->mensaje = 'el json no tenia los parametros';
        $json_ovni = json_decode($json_ovni);

        if(isset($json_ovni->tipo) && isset($json_ovni->velocidad) && isset($json_ovni->planetaOrigen))
        {
            $ret->mensaje = 'El ovni ya existia en la base de datos';


            //creo el objeto, para eso primero genero el nombre de la foto, para guardarlo en su parametro
            $pathFoto = Ovni::GenerarNombreFoto($foto, $json_ovni->tipo, $json_ovni->planetaOrigen);
            $ovni = new Ovni($json_ovni->tipo, $json_ovni->velocidad, $json_ovni->planetaOrigen, $pathFoto);

            if(!$ovni->Existe(Ovni::Traer()))
            {
                $ret->mensaje = 'el ovni no se pudo agregar';

                if($ovni->Agregar())
                {
                    $ret->exito = true;
                    $ret->mensaje = 'Ovni agregado con exito';

                    move_uploaded_file($foto["tmp_name"],"./ovnis/imagenes/" . $pathFoto);

                    header('Location: ./Listado.php');
                }
            }
        }
    }

    echo json_encode($ret);
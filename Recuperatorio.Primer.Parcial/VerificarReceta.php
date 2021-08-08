<?php

    require_once './clases/receta.php';

    $receta_json = isset($_POST['receta']) ? $_POST['receta'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'no se recibieron los parametros';

    if($receta_json !== false)
    {
        $ret->mensaje = 'el json no tenia los parametros';
        $receta_json = json_decode($receta_json);

        if(isset($receta_json->nombre) && isset($receta_json->tipo))
        {
            $ret->mensaje = 'El producto no existe en la base de datos';

            $receta = new Receta(null, $receta_json->nombre, null, $receta_json->tipo);
            $recetas_array = $receta->Traer();

            if($receta->Existe($recetas_array))
            {
                $ret->datos = json_decode($receta->ToJson());
                $ret->exito = true;
                $ret->mensaje = 'El producto existe en la base de datos';
            }
            else{
                foreach ($recetas_array as $unaReceta) {
    
                    if ($receta->nombre != $unaReceta->nombre) {

                        $ret->mensaje =  "No hay coincidencias con ese Nombre!";
                        break;
                    
                    } else if ($unaReceta->tipo != $receta->tipo) {
                
                        $ret->mensaje =  "No hay coincidencias con ese tipo!";
                        break;
                    }
                }
            }
            
        }
    }

    echo json_encode($ret);
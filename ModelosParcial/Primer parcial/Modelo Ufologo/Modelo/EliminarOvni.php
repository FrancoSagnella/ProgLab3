<?php

    require_once './clases/ovni.php';

    $id_get = isset($_GET['id']) ? $_GET['id'] : false;
    $id_post = isset($_POST['id']) ? $_POST['id'] : false;
    $accion = isset($_POST['accion']) ? $_POST['accion'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'No se recibieron parametros';

    //se envia por get
    if($id_get !== false)
    {
        $ret->mensaje = 'El ovni NO existe en la base de datos';

        if(Ovni::TraerId($id_get))
        {
            $ret->exito = true;
            $ret->mensaje = 'El ovni existe en la base de datos';
        }

        
    }
    //se envia por post id y borrar
    else if($id_post !== false && $accion === 'borrar')
    {
        $ret->mensaje = 'Ese ovni no existe en la base de datos';

        $ovni_array = Ovni::TraerId($id_post);
        //si es diferente de false, quiere decir que lo encontro
        if($ovni_array !== false)
        {
            $ret->mensaje = 'el ovni no se pudo eliminar';

            if(Ovni::Eliminar($id_post))
            {
                $ret->exito = true;
                $ret->mensaje = 'Ovni eliminado con exito';

                //ahora tengo que guardar los datos del ovni que elimine en el archivo de borrados y mover la foto 
                $ovni_array[0]->GuardarEnArchivo();

                header('Location: ./Listado.php');

            }
        
    }}
    //no se envia parametro con borrar
    else if($id_post !== false && $accion !== 'borrar')
    {
        $ret->mensaje = 'No se recibio accion == borrar';
    }
    else
    {
        $ovniArray = Ovni::MostrarBorrados();

                $tabla = "<table border=1>
                            <thead>
                                <tr>
                                    <td>Tipo</td>
                                    <td>Velocidad</td>
                                    <td>Velocidad Warp</td>
                                    <td>Planeta</td>
                                    <td>Foto</td>
                                </tr>
                            </thead>
                            <tbody>";

                            foreach($ovniArray as $ovni)
                            {
                                $tabla.="<tr><td width=90 height=90 >$ovni->tipo</td>
                                <td>$ovni->velocidad</td>
                                <td>".$ovni->ActivarVelocidadWarp()."</td>
                                <td>$ovni->planetaOrigen</td>";
                                
                                if($ovni->pathFoto != null)

                                    $tabla.="<td><img src='./ovnisBorrados/".$ovni->pathFoto."' width=90 height=90 /></td>";

                                $tabla.="</td></tr>";
                            }
                $tabla .=   "</tbody>
                          </table>";

                echo $tabla;
    }
    
    echo json_encode($ret);
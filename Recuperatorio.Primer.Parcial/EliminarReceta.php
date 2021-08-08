<?php

require_once './clases/receta.php';

$receta_json = isset($_POST['receta_json']) ? $_POST['receta_json'] : false;
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : false;
$accion = isset($_POST['accion']) ? $_POST['accion'] : false;

$ret = new stdClass();
$ret->exito = false;
$ret->mensaje = 'no se recibieron los parametros';

if($receta_json !== false && $accion === 'borrar')
{
    $ret->mensaje = 'el json no tenia los parametros';
    $receta_json = json_decode($receta_json);

    if(isset($receta_json->id) && isset($receta_json->tipo) && isset($receta_json->nombre))
    {
        $ret->mensaje = 'No se pudo eliminar el receta de la base de datos';
        $receta = new Receta($receta_json->id, $receta_json->nombre, null, $receta_json->tipo);
        //si devolvio true es que se borro
        if($receta->Eliminar())
        {
            $ret->exito = true;
            $ret->mensaje = 'receta eliminada';
            //guardo los datos en el archivo de borrados internamente mueve la foto
            $receta->GuardarEnArchivo();
        }
    }

    echo json_encode($ret);
}
else{
    if($nombre !== false)
    {
        $recetasArray = Receta::Traer();
        foreach($recetasArray as $aux)
        {
            if($aux->nombre === $nombre)
            {
                echo 'La receta existe en la base de datos';
                break;
            }
        }
    }
    else{
        $recetas_array = Receta::MostrarBorrados();

                $tabla = "<table border=1>
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Ingredientes</td>
                                    <td>Tipo</td>
                                    <td>Foto</td>
                                </tr>
                            </thead>
                            <tbody>";

                            foreach($recetas_array as $receta)
                            {
                                $tabla.="<tr><td width=90 height=90 >$receta->nombre</td>
                                <td>$receta->ingredientes</td>
                                <td>$receta->tipo</td>";
                                
                                if($receta->pathFoto != null)

                                    $tabla.="<td><img src='./recetasBorradas/".$receta->pathFoto."' width=90 height=90 /></td>";

                                $tabla.="</td></tr>";
                            }
                $tabla .=   "</tbody>
                          </table>";

                echo $tabla;
    }
       
}
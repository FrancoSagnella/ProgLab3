<?php
    require_once "./clases/receta.php";

    $aux = isset($_GET) ? true : false;

    if($aux){

        $recetas_array = Receta::Traer();

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

                                    $tabla.="<td><img src='./recetas/imagenes/".$receta->pathFoto."' width=90 height=90 /></td>";

                                $tabla.="</td></tr>";
                            }
                $tabla .=   "</tbody>
                          </table>";

                echo $tabla;
    }
    else{
        echo 'No se recibio parametro GET';
    }
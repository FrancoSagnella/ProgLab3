<?php
    require_once "./clases/ovni.php";

    $aux = isset($_GET) ? true : false;

    if($aux){

        $ovniArray = Ovni::Traer();

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

                                    $tabla.="<td><img src='./ovnis/imagenes/".$ovni->pathFoto."' width=90 height=90 /></td>";

                                $tabla.="</td></tr>";
                            }
                $tabla .=   "</tbody>
                          </table>";

                echo $tabla;
    }
    else{
        echo 'No se recibio parametro GET';
    }
<?php

require_once 'clases/productoEnvasado.php';

$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : false;

if($tabla === 'mostrar')
{
    $productos_array = ProductoEnvasado::Traer();

                $tabla = "<table border=1>
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Origen</td>
                                    <td>Codigo de Barra</td>
                                    <td>Precio</td>
                                    <td>Foto</td>
                                </tr>
                            </thead>
                            <tbody>";

                            foreach($productos_array as $prod)
                            {
                                $tabla.="<tr><td width=90 height=90 >$prod->nombre</td>
                                <td>$prod->origen</td>
                                <td>".$prod->codigoBarra."</td>
                                <td>$prod->precio</td>";
                                
                                if($prod->pathFoto != null)

                                    $tabla.="<td><img src='./productos/imagenes/".$prod->pathFoto."' width=90 height=90 /></td>";

                                $tabla.="</td></tr>";
                            }
                $tabla .=   "</tbody>
                          </table>";

                echo $tabla;
}
else{
    echo json_encode(ProductoEnvasado::Traer());
}
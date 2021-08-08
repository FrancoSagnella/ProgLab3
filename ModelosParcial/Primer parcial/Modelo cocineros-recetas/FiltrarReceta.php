<?php
require "./clases/Recetas.php";

$nombre = $_POST["nombre"] ?? NULL;
$tipo = $_POST["tipo"] ?? NULL;

$listadoReceta = array();
$recetaRandom = new Recetas("", "", "", "");
$listadoReceta = $recetaRandom->Traer();
$nombreTipo = false;
$nombreSolo = false;
$tipoSolo = false;
if ($nombre != NULL && $tipo != NULL)
    $nombreTipo = true;

if ($tipo == NULL)
    $nombreSolo = true;

if ($nombre == NULL)
    $tipoSolo = true;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>

<body>
    <th>
        <h4>Filtrado por <?php if ($nombreTipo) {
                                echo "Nombre y Tipo";
                            } else if ($nombreSolo) {
                                echo "Nombre";
                            } else if ($tipoSolo) {
                                echo "Tipo";
                            } ?></h4>
    </th>
    <table>
        <tr>
            <td colspan="4">
                <hr />
            </td>
        </tr>
        <tr>
            <th>Nombre</th>
            <th>Ingredientes</th>
            <th>Tipo</th>
            <th>Foto</th>
        </tr>
        <?php
        if ($nombreTipo) {
            foreach ($listadoReceta as $key) {
                if ($key->nombre == $nombre && $key->tipo == $tipo) { ?>
                    <tr>
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->ingredientes ?></td>
                        <td><?php echo $key->tipo ?></td>
                        <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists("./recetas/imagenes/" . $key->pathFoto)) {
                                echo "<td><img src=./recetas/imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                
                                $flag = true;
                            }
                            if (file_exists("./recetasModificadas/imagenes" . $key->pathFoto)) {
                                echo "<td><img src=./recetasModificadas/imagenes" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if ($flag == false)
                                echo '<td>SinFoto</td';
                        }
                    }
                }
                echo '</tr>';
               
            } else if ($nombreSolo) {
                foreach ($listadoReceta as $key) {
                    if ($key->nombre == $nombre) { ?>
                    <tr>
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->ingredientes ?></td>
                        <td><?php echo $key->tipo ?></td>
                        <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists("./recetas\imagenes/" . $key->pathFoto)) {
                                echo "<td><img src=./recetas\imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if (file_exists("./recetasModificadas/imagenes" . $key->pathFoto)) {
                                echo "<td><img src=./recetasModificadas/imagenes" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if ($flag == false)
                                echo '<td>SinFoto</td';
                        }

                        echo '</tr>';
                    }
                }
            } else if ($tipoSolo) {
                foreach ($listadoReceta as $key) {
                    if ($key->tipo == $tipo) { ?>
                    <tr>
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->ingredientes ?></td>
                        <td><?php echo $key->tipo ?></td>
            <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists("./recetas/imagenes/" . $key->pathFoto)) {
                                echo "<td><img src=./recetas/imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if (file_exists("./recetasModificadas/imagenes" . $key->pathFoto)) {
                                echo "<td><img src=./recetasModificadas/imagenes" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if ($flag == false)
                                echo '<td>SinFoto</td';
                        }

                        echo '</tr>';
                       
                    }
                }
            } ?>
                    <tr>
                        <td colspan="4">
                            <hr />
                        </td>
                    </tr>
    </table>
</body>
</body>

</html>

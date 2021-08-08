<?php
require "./clases/Recetas.php";

$nombre = $_GET["nombre"] ?? NULL;
$receta = $_POST["receta_json"] ?? NULL;
$accion = $_POST["accion"] ?? NULL;

$newReceta = new Recetas("", "", "", "");
if ($receta == NULL) {
    if ($nombre != NULL) {
        $listaRecetas = array();
        $listaRecetas = $newReceta->Traer();
        $retorno = "La Receta NO Esta en la Base de Datos";
        foreach ($listaRecetas as $key) {
            if ($key->nombre == $nombre) {
                $retorno = "La Receta Esta en la Base de Datos";
                break;
            }
        }
        echo $retorno;
    } else {
        $listaBorrados = Recetas::MostrarBorrados();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>

        <body>
            <table>
                <th>
                    <h4>Listado Recetas Eliminadas</h4>
                </th>
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
                <?php foreach ($listaBorrados as $key) { ?>
                    <tr>
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->ingredientes ?></td>
                        <td><?php echo $key->tipo ?></td>
                        <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists("./recetasBorradas/" . chop($key->pathFoto))) {
                                echo "<td><img src=./recetasBorradas/" . chop($key->pathFoto) . " height='100px' width='100px'></td>";
                            } else
                                echo '<td>SinFoto</td';
                        }
                        ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
            </table>
        </body>

        </html>

<?php }
} else {
    $receta = json_decode($_POST["receta_json"]);
    $js = new stdClass();
    if ($accion == "borrar") {
        $js->exito = false;
        $js->mensaje = "No se pudo borrar de la base de datos";
        $recetaFake = new Recetas($receta->id, "", "", "");
        $listaRecetas = $recetaFake->Traer();
        $recetaBorrar = null;
        
        foreach ($listaRecetas as $key) {
            
            if ($key->id == $recetaFake->id) {
                $recetaBorrar = new Recetas($key->id, $key->nombre, $key->ingredientes, $key->tipo, $key->pathFoto);
                break;
            }
        }
        if($recetaBorrar!=NULL)
        {
            if ($recetaBorrar->Eliminar()) {
                $js->exito = true;
                $js->mensaje = "Se ha Borrado de la clase y se a Guardado en Borrados";
                $recetaBorrar->GuardarEnArchivo();
            }
        }
        
        echo json_encode($js);
    }
}

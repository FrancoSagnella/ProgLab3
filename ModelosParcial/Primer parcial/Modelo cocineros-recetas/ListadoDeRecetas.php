<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de Ciudades</title>
</head>
<body>
    <table border=2>
        <thead><tr><td>Nombre</td><td>Ingredientes</td><td>Tipo</td> <td>Foto</td></tr></thead>
        <?php
            require_once "./Clases/Recetas.php";
            $receta = new Recetas();
            $lista = $receta->Traer();
            $tabla = "";
            
            foreach($lista as $aux)
            {
                $tabla.= "<tr>
                            <td>" . $aux->nombre . "</td>
                             <td>" . $aux->ingredientes . "</td>
                             <td>" . $aux->tipo . "</td>";

                if($aux->pathFoto != null)
                {
                    $tabla .= "<td><img src='./recetas/imagenes/" . $aux->pathFoto . "'></td>";
                    //var_dump($aux->pathFoto);
                }
                else{
                    $tabla.= "<td></td>";
                }
                $tabla.= "</tr>";
            } 
            $tabla.= "</table>";
            echo $tabla;
        ?>
    </table>
</body>
</html>
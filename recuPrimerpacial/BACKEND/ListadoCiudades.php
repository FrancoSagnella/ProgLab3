<?php
require_once "./clases/Ciudad.php";
//$receta=new Recetas();
$dato=isset($_GET["dato"]) ? $_GET["dato"]:null;

$lista=Ciudad:: Traer();
if($dato=="json")
{
    $json=new stdClass();
    $json->dato=$lista;
    echo json_encode($json);
   /* foreach($lista as $producto)
    {
        echo $producto->ToJSon();
       
    }*/
    // INTENTAR PARAR ACA  
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<table border=1>
    <tr>
          <th> ID</th>
        <th>NOMBRE</th>
        <th>PAIS</th>
        <th>POBLACIO</th>
        <th>FOTO</th>

    </tr>
    <?php
        foreach($lista as $aux)
        {
             echo " <tr>
                     <td>". $aux->id ."</td>
                    <td>". $aux->nombre ."</td>
                    <td>". $aux->pais ."</td>
                    <td>". $aux->poblacion ."</td>

                    <td> "
                
                    ;
              if($aux->pathFoto!=null)
              {
               echo"<img src='./ciudades/imagenes/". $aux->pathFoto . "' width='85' height='85'>";
            }       
            echo "</td></tr>";
        }
    ?>
</table>
<body>
    
</body>
</html>
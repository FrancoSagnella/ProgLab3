

<?php
require_once "./clases/ProductoEnvasado.php";
$tabla=isset($_GET["tabla"])? $_GET["tabla"]:null;
$lista=ProductoEnvasado::Traer();
//echo var_dump($lista);
if($tabla!="mostrar")
{
    echo json_encode($lista);
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

<table>
    <tr>
         <th>ID</th>
         <th>CODIGO B.</th>
        <th>NOMBRE</th>
        <th>ORIGEN</th>
        <th>PRECIO</th>
        <th>FOTO</th>
        
    </tr>
    <?php
        foreach($lista as $producto)
        {
            echo "<tr>
                    <td>". $producto->id ."</td>
                    <td>". $producto->codigoBarra ."</td>
                    <td>". $producto->nombre ."</td>
                    <td>". $producto->origen ."</td>
                    <td>". $producto->precio ."</td>
                    <td><img src='". $producto->foto . "'></td>
                  </tr>
                    ";
        }
    ?>
</table>
<body>
    
</body>
</html>
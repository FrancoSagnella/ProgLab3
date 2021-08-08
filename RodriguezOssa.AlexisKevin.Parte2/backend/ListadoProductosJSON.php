<?php
require_once "./clases/Producto.php";

$lista=Producto::TraerJSon();
echo json_encode($lista);
/*foreach($lista as $usuario)
{
    echo $usuario->ToJSon() . "<br>";
}*/
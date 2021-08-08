<?php
require_once "./clases/Producto.php";

$origen= isset($_POST["origen"]) ? $_POST["origen"]:null;
$nombre=isset($_POST["nombre"])? $_POST["nombre"]:null;
$producto=new Producto($nombre,$origen);
$respuesta=$producto->GuardarJSON("./archivos/productos.json");
echo json_encode($respuesta) ;
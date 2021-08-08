<?php
require_once "./clases/Producto.php";
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : false;

    if($nombre != false && $origen != false)
    {
        $prod = new Producto($nombre, $origen);
        echo $prod->GuardarJSON("./archivos/productos.json");
    }
<?php
    require_once "./clases/Producto.php";
    $aux = isset($_GET) ? true : false;

    if($aux){
        $prod_array = Producto::TraerJSON();
        echo json_encode($prod_array);
    }
    else{
        echo 'No se recibio GET';
    }
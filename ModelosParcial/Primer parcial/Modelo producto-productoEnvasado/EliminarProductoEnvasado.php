<?php

    require_once './clases/productoEnvasado.php';

    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'no se recibieron los parametros';

    if($producto_json !== false)
    {
        $ret->mensaje = 'el json no tenia los parametros';
        $producto_json = json_decode($producto_json);

        if(isset($producto_json->id) && isset($producto_json->nombre) && isset($producto_json->origen))
        {
            $ret->mensaje = 'no se pudo eliminar el producto';

           if(ProductoEnvasado::Eliminar($producto_json->id))
            {
                $ret->exito = true;
                $ret->mensaje = 'producto eliminado con exito';
                $prod = new Producto($producto_json->nombre, $producto_json->origen);
                $ret->escrituraArchivo = json_decode($prod->GuardarJSON('./archivos/productos_eliminados.json'))->mensaje;
            }
        }
    }

    echo json_encode($ret);
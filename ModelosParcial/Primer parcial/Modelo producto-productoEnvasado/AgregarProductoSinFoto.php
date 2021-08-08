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

        if(isset($producto_json->codigoBarra) && isset($producto_json->nombre) && isset($producto_json->origen) && isset($producto_json->precio))
        {
            $ret->mensaje = 'no se pudo agregar el producto';

            $prod = new ProductoEnvasado(null, $producto_json->nombre, $producto_json->origen, $producto_json->codigoBarra, $producto_json->precio);
            if($prod->Agregar())
            {
                $ret->exito = true;
                $ret->mensaje = 'producto agregado con exito';
            }
        }
    }

    echo json_encode($ret);
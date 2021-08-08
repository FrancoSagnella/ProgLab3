<?php

    require_once './clases/productoEnvasado.php';

    $obj_producto = isset($_POST['obj_producto']) ? $_POST['obj_producto'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'no se recibieron los parametros';
    $ret->datos = json_decode('{}');

    if($obj_producto !== false)
    {
        $ret->mensaje = 'el json no tenia los parametros';
        $obj_producto = json_decode($obj_producto);

        if(isset($obj_producto->nombre) && isset($obj_producto->origen))
        {
            $ret->mensaje = 'El producto no existe en la base de datos';

            $prod = new ProductoEnvasado(null, $obj_producto->nombre, $obj_producto->origen);
            $productos_array = $prod->Traer();

            if($prod->Existe($productos_array))
            {
                $ret->datos = json_decode($prod->ToJson());
                $ret->exito = true;
                $ret->mensaje = 'El producto existe en la base de datos';
            }
            
        }
    }

    echo json_encode($ret);
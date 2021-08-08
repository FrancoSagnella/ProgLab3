<?php
require_once "./clases/ProductoEnvasado.php";
$producto=isset($_POST["producto_json"])? json_decode($_POST["producto_json"]) :null;
$validarJSon=json_decode('{"validar":"false", "mensaje":"No se pudo modiifcar"}');

$json = new stdClass();
$productoModicar=new ProductoEnvasado($producto->nombre,$producto->origen,$producto->id,$producto->codigoBarra,null,$producto->precio);
if($productoModicar->Modificar())
    {
        $json->validar = true;
        $json->mensaje = "Se modifico correctamente";
        echo json_encode($json);
    }
    else
    {;
        echo json_encode($json);
    }
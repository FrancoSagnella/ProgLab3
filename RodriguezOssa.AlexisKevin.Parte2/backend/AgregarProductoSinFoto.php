<?php
require_once "./clases/ProductoEnvasado.php";
$producto=isset($_POST["producto_json"])? json_decode($_POST["producto_json"]) :null;
$validarJSon=json_decode('{"validar":"false", "mensaje":"no se puedo agregar"}');
$productoAgregar=new ProductoEnvasado($producto->nombre,$producto->origen,null,$producto->codigoBarra,null,$producto->precio);
if($productoAgregar->Agregar())
{
    $validarJSon->validar="true";
    $validarJSon->mensaje="guardado correctamente";

    echo json_encode($validarJSon);
}
else
{
    echo json_encode($validarJSon);
}
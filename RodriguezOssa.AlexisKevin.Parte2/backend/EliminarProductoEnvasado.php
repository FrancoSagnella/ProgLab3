<?php
require_once "./clases/ProductoEnvasado.php";
require_once "./clases/Producto.php";

$producto=isset($_POST["producto_json"])? json_decode($_POST["producto_json"]) :null;
$productoEliminar=new ProductoEnvasado($producto->nombre,$producto->origen,$producto->id,null,null,null);
$validarJSon=json_decode('{"validar":"false", "mensaje":"no se logro eliminar correctamente"}');

if(ProductoEnvasado:: Eliminar($producto->id))
{
    $productoGuardar=new Producto($producto->nombre,$producto->origen);
    $productoGuardarEli=$productoGuardar->GuardarJSON('./archivos/productos_eliminados.json') ;
    if($productoGuardarEli->validar)
    {
        $validarJSon->validar="true";
            $validarJSon->mensaje="eliminado correctamente";
            echo json_encode($validarJSon);
    }
}
else
{
    echo json_encode($validarJSon);
}
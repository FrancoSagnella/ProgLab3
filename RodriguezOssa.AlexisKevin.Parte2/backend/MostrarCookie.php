<?php
require_once "./clases/Producto.php";
$origen= isset($_GET["origen"]) ? $_GET["origen"]:null;
$nombre=isset($_GET["nombre"])? $_GET["nombre"]:null;
 if ($origen != NULL && $nombre != NULL)
{
    //echo "aho";
    $validarJSon=json_decode('{"validar":"false", "mensaje":"no se encontro cookie"}');

    $nombreCookie=$nombre . "_" . $origen;
    $cookie = isset($_COOKIE[$nombreCookie]) ? $_COOKIE[$nombreCookie] : NULL;
    if ($cookie != NULL)
    {
        $validarJSon->validar="true";
        $validarJSon->mensaje=$cookie;
       // echo $cookie;
        echo json_encode($validarJSon);
    }
    else
    {
        echo json_encode($validarJSon);

    }
}
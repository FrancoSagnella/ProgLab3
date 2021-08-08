<?php
include_once ("./clases/Producto.php");

$origen= isset($_POST["origen"]) ? $_POST["origen"]:null;
$nombre=isset($_POST["nombre"])? $_POST["nombre"]:null;
//echo $nombre . $origen;
if($origen != NULL && $nombre != NULL){
    $producto=new Producto($nombre,$origen);
    $verificar=json_decode( (Producto::VerificarProductoJSon($producto))); 
    if ($verificar->validar){
        //$date=date("d/m/Y-H:i:s");
        // echo(setcookie($producto->nombre. "_" . $producto->origen, $date . $verificar->mensaje ));

        setcookie($nombre . "_" . $origen,  $verificar->mensaje);
        
            
            echo json_encode($verificar) ;
        
            
    }
    else{
        echo json_encode($verificar);
    }
}/*


require_once "./clases/Producto.php";
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : false;

    if($nombre != false && $origen != false)
    {

        $producto = new Producto($nombre, $origen);
        $ret = json_decode(Producto::VerificarProductoJSon($producto));

        if($ret->validar){
            //date_default_timezone_set("America/Argentina/BuenosAires");
            $date = date("d/m/Y-H:i:s");
            setcookie($nombre . "" . $origen, $date . " " . $ret->mensaje);

            echo json_encode($ret);
        }
        else{
            echo json_encode($ret);
        }
    }*/
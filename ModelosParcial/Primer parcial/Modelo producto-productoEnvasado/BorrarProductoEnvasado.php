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

    if(isset($producto_json->id) && isset($producto_json->codigoBarra) && isset($producto_json->nombre) && isset($producto_json->origen) && isset($producto_json->precio) && isset($producto_json->pathFoto))
    {
        $ret->mensaje = 'No se pudo eliminar el producto de la base de datos';
        $prod = new ProductoEnvasado($producto_json->id, $producto_json->nombre, $producto_json->origen, $producto_json->codigoBarra, $producto_json->precio, $producto_json->pathFoto);
        //si devolvio true es que se borro
        if(ProductoEnvasado::Eliminar($producto_json->id))
        {
            $ret->exito = true;
            $ret->mensaje = 'producto eliminado';
            //guardo los datos en el archivo de borrados internamente mueve la foto
            $prod->GuardarEnArchivo();
        }
    }

    echo json_encode($ret);
}
else{
       $productos_array = ProductoEnvasado::MostrarBorrados();

                $tabla = "<table border=1>
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Origen</td>
                                    <td>Codigo de Barra</td>
                                    <td>Precio</td>
                                    <td>Foto</td>
                                </tr>
                            </thead>
                            <tbody>";

                            foreach($productos_array as $prod)
                            {
                                $tabla.="<tr><td width=90 height=90 >$prod->nombre</td>
                                <td>$prod->origen</td>
                                <td>".$prod->codigoBarra."</td>
                                <td>$prod->precio</td>";
                                
                                if($prod->pathFoto != null)

                                    $tabla.="<td><img src='./productosBorrados/".$prod->pathFoto."' width=90 height=90 /></td>";

                                $tabla.="</td></tr>";
                            }
                $tabla .=   "</tbody>
                          </table>";

                echo $tabla;
}
<?php

    require_once './clases/productoEnvasado.php';

    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : false;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = 'no se recibieron los parametros';

    if($producto_json !== false && $foto !== false)
    {
        $ret->mensaje = 'el json no tenia los parametros';
        $producto_json = json_decode($producto_json);

        if(isset($producto_json->id) && isset($producto_json->nombre) && isset($producto_json->origen) && isset($producto_json->codigoBarra) && isset($producto_json->precio))
        {
            $ret->mensaje = 'El producto no existia en la base de datos';

            //creo el objeto, para eso primero genero el nombre de la foto, para guardarlo en su parametro
            $pathFoto = ProductoEnvasado::GenerarNombreFoto($foto, $producto_json->nombre, $producto_json->origen);
            $prod = new ProductoEnvasado($producto_json->id, $producto_json->nombre, $producto_json->origen, $producto_json->codigoBarra, $producto_json->precio, $pathFoto);

            //si no lo que pdria hacer, es directamente traer uno de la base de datos, con un metodo traer uno
            //si me trajo algo entro al modificar, si se modifico guardo la foto nueva, agarro ese que me habia traido y muevo su foto
            //en ambos casos tengo que crear un etodo nuevo, trearUno($id) o ExisteId($array) que me compare por ids
            $productoArray = ProductoEnvasado::Traer();
            //Me fijo si existe ese id, si no aviso que no esta ese id en la base
            if($prod->ExisteId($productoArray))
            {
                $ret->mensaje = 'el producto no se pudo modificar';

                if($prod->Modificar())
                {
                    $ret->exito = true;
                    $ret->mensaje = 'producto modificado con exito';

                    //guardo la foto nueva 
                    move_uploaded_file($foto["tmp_name"],"./productos/imagenes/" . $pathFoto);

                    //recorro el array de productos para recuperar los datos del producto que modifique
                    foreach($productoArray as $producto)
                    {
                        if($producto->id = $prod->id)
                        {
                            //si ese producto tenia foto, la muevo al directorio de modificadas, si no no hago nada, no tenia foto
                            if($producto->pathFoto !== null)
                            {
                                ProductoEnvasado::MoverFoto($producto->pathFoto, $producto, 'modificado');
                            }
                        }
                    }
                }
            }
        }
    }

    echo json_encode($ret);
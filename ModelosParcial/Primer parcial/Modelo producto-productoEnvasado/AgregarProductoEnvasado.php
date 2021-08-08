<?php

    require_once "./clases/ProductoEnvasado.php";

    $codigoBarra = isset($_POST['codigoBarra']) ? $_POST['codigoBarra'] : false;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : false;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;

    $ret = new stdClass();
    $ret->exito = false;
    $ret->mensaje = "No se recibieron los parametros requeridos";

    if($codigoBarra != false && $nombre != false && $origen != false && $precio != false && $foto != false)
    {
        $ret->mensaje = 'El producto ya existe en la base de datos';

        //le guarda o el nombre de la foto, o null si fallo algo
        $pathFoto = ProductoEnvasado::GenerarNombreFoto($foto, $nombre, $origen);
        $prod = new ProductoEnvasado(null, $nombre, $origen, $codigoBarra, $precio, $pathFoto);

        if(!$prod->Existe(ProductoEnvasado::Traer()))
        {
            $ret->mensaje = 'No se pudo agregar el producto a la base de datos';

            if($prod->Agregar())
            {
                $ret->exito = true;
                $ret->mensaje = 'producto agregado con exito';

                //ya a estas alturas el path foto no deberia poder ser null, porque ya lo valide, pero igual
                if($pathFoto !== null)
                {
                    move_uploaded_file($foto["tmp_name"], "./productos/imagenes/" . $pathFoto);
                }
            }
        }
    }

    echo json_encode($ret);
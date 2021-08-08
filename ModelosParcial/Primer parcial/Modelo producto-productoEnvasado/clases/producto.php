<?php

class Producto{
    public $nombre;
    public $origen;

    public function __construct($nombre, $origen)
    {
        $this->nombre = $nombre;
        $this->origen = $origen;
    }

    public function ToJson()
    {
        //Esto lo puedo hacer solo porque todos los atributos son publicos
        return json_encode($this);
    }

    public function GuardarJSON($path)
    {
        //creo stdclass para el retorno
        $ret = new stdClass();
        $ret->exito = true;
        $ret->mensaje = "Se escribio en el archivo con exito";

        //esto escribe algo en un archivo, en vez de abrir el archivo, escribir y despues cerrarlo puedo hacer esto
        //le paso el archivo, la cadena que quiero escribir, FILE_APPEND es para que no se sobreescriba
        if (!file_put_contents($path, $this->ToJSON() . "\n", FILE_APPEND)) {
            //devuelve numeros, si es igual a 0 quiere decir que no escribio, retorno false y mensaje de error
            $ret->exito = false;
            $ret->mensaje = "No se pudo escribir en el archivo";
        }
        //el objeto de retorno lo encodeo en cadena json
        return json_encode($ret);
    }

    public static function TraerJSON()
    {
        $ret = array();

        //abro el archivo
        $f = fopen("./archivos/productos.json", "r");

        //lo voy leyendo
        while (!feof($f)) {

            //leo una linea, el trim para sacarle espacios en blanco y \n
            $line = trim(fgets($f));
            //si linea es diferente de null, quiere decir que leyo algo
            if ($line != null)
            {
                //queda una cadena json, hago json decode para tener un objeto stdClass
                $prod = json_decode($line);
                //cargo en el array que cree el ufologo
                array_push($ret, new Producto($prod->nombre, $prod->origen));
            }
        }
        //cierrro el archivo
        fclose($f);

        //retorno el array, va a tener los ufologos, o va a estar vacio si no leyo nada
        return $ret;
    }

    public static function VerificarProductoJSON($producto)
    {
        $ret = new stdClass();
        $ret->existe = false;
        $ret->mensaje = 'La lista de prodcutos estaba vacia';
        
        $contNombres = array();
        $contOrigen = 0;

        $array_productos = Producto::TraerJSON();

        foreach($array_productos as $prod)
        {
            if($prod->origen === $producto->origen)
            {
                if($prod->nombre === $producto->nombre)
                {
                    $ret->existe = true;
                }
                $contOrigen++;
                
            }

            if(!isset($contNombres[$prod->nombre]))
            {
                $contNombres[$prod->nombre] = 1;
            }
            else{
                $contNombres[$prod->nombre]++;
            }
        }
        

        if($ret->existe === true)
        {
            $ret->mensaje = "El producto existe, hay ".$contOrigen." productos con el mismo origen";
        }
        else
        {
            $aux = 0;
            foreach($contNombres as $nombre => $cantidad)
            {
                if($cantidad > $aux)
                {
                    $ret->mensaje = "El producto NO existe, los productos mas populares son: ".$nombre.", apareciendo ".$cantidad." veces";
                    $aux = $cantidad;
                }
                else if($cantidad == $aux && $aux != 0)
                {
                    $ret->mensaje .= ", ".$nombre.", apareciendo ".$cantidad." veces";
                }
            }
        }
        return json_encode($ret);
    }
}
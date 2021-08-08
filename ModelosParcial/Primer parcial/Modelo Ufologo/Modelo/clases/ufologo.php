<?php

class Ufologo{

    private $pais;
    private $legajo;
    private $clave;

    public function __construct($pais, $legajo, $clave)
    {
        $this->pais = $pais;
        $this->legajo = $legajo;
        $this->clave = $clave;
    }

    public function ToJson()
    {
        //este metodo me gusta, hago un array con los atributos del ufologo, porque al ser privados no puedo encode directo
        return json_encode(array('pais' => $this->pais, 'legajo' => $this->legajo, 'clave' => $this->clave));
    }

    public function GuardarEnArchivo()
    {
        //creo stdclass para el retorno
        $ret = new stdClass();
        $ret->exito = true;
        $ret->mensaje = "Se escribio en el archivo con exito";

        //esto escribe algo en un archivo, en vez de abrir el archivo, escribir y despues cerrarlo puedo hacer esto
        //le paso el archivo, la cadena que quiero escribir, FILE_APPEND es para que no se sobreescriba
        if (!file_put_contents("./archivos/ufologos.json", $this->ToJSON() . "\n", FILE_APPEND)) {
            //devuelve numeros, si es igual a 0 quiere decir que no escribio, retorno false y mensaje de error
            $ret->exito = false;
            $ret->mensaje = "No se pudo escribir en el archivo";
        }
        //el objeto de retorno lo encodeo en cadena json
        return json_encode($ret);
    }

    public static function TraerTodos()
    {
        $ret = array();

        //abro el archivo
        $f = fopen("./archivos/ufologos.json", "r");

        //lo voy leyendo
        while (!feof($f)) {

            //leo una linea, el trim para sacarle espacios en blanco y \n
            $line = trim(fgets($f));
            //si linea es diferente de null, quiere decir que leyo algo
            if ($line != null)
            {
                //queda una cadena json, hago json decode para tener un objeto stdClass
                $ufologo = json_decode($line);
                //cargo en el array que cree el ufologo
                array_push($ret, new Ufologo($ufologo->pais, $ufologo->legajo, $ufologo->clave));
            }
        }
        //cierrro el archivo
        fclose($f);

        //retorno el array, va a tener los ufologos, o va a estar vacio si no leyo nada
        return $ret;
    }

    public static function VerificarExistencia($ufologo)
    {
        //creo el retorno para despues armar el json
        $ret = new stdClass();
        $ret->exito = false;
        $ret->mensaje = 'No existe el ufologo en el archivo';

        //traigo el array de todos
        $ufologo_array = Ufologo::TraerTodos();

        //lo recorro
        foreach($ufologo_array as $obj)
        {
            //comparo legajo y calve
            if($obj->legajo === $ufologo->legajo && $obj->clave === $ufologo->clave)
            {
                //si existe devuelvo true
                $ret->exito = true;
                $ret->mensaje = 'El ufologo existe en el archivo';
                break; 
            }
        }
        //devuelvo ret formateado como json
        return json_encode($ret);
    }
}
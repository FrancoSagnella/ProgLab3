<?php
    class Enigma
    {
        static function encriptar($mensaje, $path)
        {
            $f = fopen($path, "w");

            $arrayAux = str_split($mensaje);
            foreach($arrayAux as $value)
            {
                fputs($f, (ord($value) + 200) . "\r\n");
            }

            fclose($f);
        }

        static function desencriptar($path)
        {
            $f = fopen($path, "r");

            $ret = "";
            while(!feof($f))
            {
                $stringAux = fgets($f);
                $stringAux = trim($stringAux);

                if($stringAux != "")
                {
                    $intAux = intval($stringAux) - 200;
                    $ret .= chr($intAux);   
                }
            }

            fclose($f);

            return $ret;
        }
    }

    Enigma::encriptar("Voy a desencriptar un mensaje re largo mal", "./misArchivos/archivoEj28.txt");
    echo Enigma::desencriptar("./misArchivos/archivoEj28.txt");
    
<?php

function copiarArchivo($archivoACopiar)
{
    $fecha = date("Y_m_d_H_i_s");
    $f = fopen($archivoACopiar, "r");
    $fcopy = fopen("./misArchivos/$fecha.txt", "w");

    while(!feof($f))
    {
        $stringAux = fgets($f);
        fputs($fcopy, $stringAux);
    }

    fclose($f);
    fclose($fcopy);
}

copiarArchivo("./misArchivos/archivoEj26.txt");
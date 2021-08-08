<?php

function copiarArchivo($archivoACopiar)
{

    $f = fopen($archivoACopiar, "r");
    
    $stringAux = "";
    while(!feof($f))
    {
        $stringAux .= fgets($f);
    }

    fclose($f);

    $fecha = date("Y_m_d_H_i_s");
    $fcopy = fopen("./misArchivos/$fecha.txt", "w");

    $arrayAux = str_split($stringAux);
    $arrayAux = array_reverse($arrayAux);
    $stringResultado = implode($arrayAux);

    fputs($fcopy, $stringResultado);

    fclose($fcopy);
}

copiarArchivo("./misArchivos/archivoEj27.txt");
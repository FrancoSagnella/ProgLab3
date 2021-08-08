<?php

    $unaLetra = 0;
    $dosLetras = 0;
    $tresLetras = 0;
    $cuatroLetras = 0;
    $masDeCuatro = 0;

    $f = fopen("./misArchivos/palabras.txt", "r");

    while(!feof($f))
    {
        $stringAux = fgets($f);
        $stringAux = trim($stringAux);

        if($stringAux != "")
        {
            $arrayAux = explode(" ", $stringAux);
            $arrayCount = count($arrayAux);

            for($i = 0; $i < $arrayCount; $i++)
            {
                $cantLetras = strlen($arrayAux[$i]);
                switch($cantLetras)
                {
                    case 1:
                        $unaLetra++;
                        break;
                    case 2:
                        $dosLetras++;
                        break;
                    case 3:
                        $tresLetras++;
                        break;
                    case 4:
                        $cuatroLetras++;
                        break;
                    default:
                        $masDeCuatro++;
                }
            }
        }
    }

    fclose($f);

    echo "Hay " . $unaLetra . " palabra de una letra<br/>";
    echo "Hay " . $dosLetras . " palabra de dos letras<br/>";
    echo "Hay " . $tresLetras . " palabra de tres letras<br/>";
    echo "Hay " . $cuatroLetras . " palabra de cuatro letras<br/>";
    echo "Hay " . $masDeCuatro . " palabra de mas de cuatro letras<br/>";

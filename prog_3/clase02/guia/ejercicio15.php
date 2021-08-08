<?php
function calcularPotencias()
{
    $ret = "";
    for($i = 1; $i <= 4; $i++)
    {
        $ret .= "Potencias de $i: ";

        for($j = 1; $j <= 4; $j++)
        {
            $ret .= " " . pow($i, $j);
        }
        $ret .= "<br/>";
    }
    return $ret;
}

echo calcularPotencias();

<?php
    require_once ("clases/empleado.php");

    $f = fopen("./archivos/empleados.txt", "r");

    while(!feof($f))
    {
        $stringAux = fgets($f);
        $stringAux = trim($stringAux);

        if($stringAux != "")
        {
            $arrayAux = explode(" - ", $stringAux);
            $empleado = new Empleado($arrayAux[0], $arrayAux[1], $arrayAux[2], $arrayAux[3], $arrayAux[4], $arrayAux[5], $arrayAux[6]);

            echo $empleado->toString() . " ";  
            ?><a href="eliminar.php?legajo=<?php echo $arrayAux[4]; ?>">Eliminar</a><?php
            echo "<br/>";
        }
    }

    fclose($f);

  
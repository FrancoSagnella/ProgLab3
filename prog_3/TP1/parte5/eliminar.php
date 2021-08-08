<?php
    require_once ("clases/fabrica.php");

    if(isset($_GET["legajo"]))
    {
        define("LEGAJO", $_GET["legajo"]);

        $boolAux = true;

        $fabrica = new Fabrica("mi fabrica", 7);
        $fabrica->traerDeArchivo("./archivos/empleados.txt");

        foreach($fabrica->getEmpleados() as $value)
        {
            if($value->getLegajo() == LEGAJO)
            {
                if($fabrica->eliminarEmpleado($value))
                {
                    //si el empleado se pudo eliminar
                    unlink($value->getPathFoto());
                    $fabrica->guardarEnArchivo("./archivos/empleados.txt");
                    echo "Empleado eliminado con exito<br/>";

                    ?> <a href="mostrar.php">Volver a Mostrar<br/></a>
                    <a href="index.php">Volver a Index</a><?php
                }
                else
                {
                    echo "El empleado no se pudo eliminmar del archivo<br/>";

                    ?> <a href="mostrar.php">Volver a Mostrar<br/></a>
                    <a href="index.php">Volver a Index</a><?php
                }
                $boolAux = false;
                break;
            }
        }

        if($boolAux)
        {
            echo "No se encontro el legajo en la lista<br/>";
            ?> <a href="mostrar.php">Volver a Mostrar<br/></a>
            <a href="index.php">Volver a Index</a><?php
        }

        /*
        $f = fopen("./archivos/empleados.txt", "r");

        $contAux = true;
        while(!feof($f))
        {
            $stringAux = fgets($f);
            $stringAux = trim($stringAux);
    
            if($stringAux != "")
            {
                $arrayAux = explode(" - ", $stringAux);
                if($arrayAux[4] == LEGAJO)
                {
                    $empleado = new Empleado($arrayAux[0], $arrayAux[1], $arrayAux[2], $arrayAux[3], $arrayAux[4], $arrayAux[5], $arrayAux[6], $arrayAux[7]);
                    $fabrica = new Fabrica("Mi Fabrica", 7);

                    $fabrica->traerDeArchivo("./archivos/empleados.txt");

                    if($fabrica->eliminarEmpleado($empleado))
                    {
                        //si el empleado se pudo eliminar
                        unlink($arrayAux[7]);
                        $fabrica->guardarEnArchivo("./archivos/empleados.txt");
                        echo "Empleado eliminado con exito<br/>";

                        ?> <a href="mostrar.php">Volver a Mostrar<br/></a>
                        <a href="index.php">Volver a Index</a><?php
                    }
                    else
                    {
                        echo "El empleado no se pudo eliminmar del archivo<br/>";

                        ?> <a href="mostrar.php">Volver a Mostrar<br/></a>
                        <a href="index.php">Volver a Index</a><?php
                    }
                    $contAux = false;
                    break;
                }
            }
        }

        if($contAux)
        {
            echo "No se encontro el legajo en la lista<br/>";
            ?> <a href="mostrar.php">Volver a Mostrar<br/></a>
            <a href="index.php">Volver a Index</a><?php
        }
    
        fclose($f);
        */
    }
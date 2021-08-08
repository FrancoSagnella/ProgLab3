<!DOCTYPE html>
<html>

<head>
    <meta charset="utf 8" />
    <title>HTML5 - Listado de Empleados</title>
</head>

<body>
    <h2>Listado de Empleados</h2>
    <table>
        <!--TABLE HEAD-->
        <thead>
            <tr>
                <td colspan="2" >
                <h4>Info</h4>                    
                </td>
            </tr>
            <tr>
                <td colspan="2" ><hr /></td>
            </tr>
        </thead>

        <!--TABLE BODY-->
        <tbody>
            <?php
            require_once ("./clases/empleado.php");

            $f = fopen("./archivos/empleados.txt", "r");
   
            while (!feof($f)) 
            {
                $stringAux = fgets($f);
                $stringAux = trim($stringAux);

                if ($stringAux != "") 
                {
                    //En cada iteracion creo una fila
                    echo "<tr>";
                        //Creo una columna para imprimir al empleado
                        echo "<td>";
                            $arrayAux = explode(" - ", $stringAux);
                            $empleado = new Empleado($arrayAux[0], $arrayAux[1], $arrayAux[2], $arrayAux[3], $arrayAux[4], $arrayAux[5], $arrayAux[6]);
                            echo $empleado->toString();
                        echo "</td>";
                        //Creo una columna para imprimir el link a Eliminar
                        echo "<td>";
                            //En este link estoy enviando por get el legajo del que quiero eliminar
                            ?><a href="eliminar.php?legajo=<?php echo $arrayAux[4]; ?>">Eliminar</a><?php
                        echo "</td>";

                    echo "</tr>";
                }
            }
                fclose($f);
            ?>
        </tbody>

        <!--TABLE FOOT-->
        <tfoot>
            <tr>
                <td colspan="2" ><hr /></td>
            </tr>
            <tr>
                <td colspan="2" >
                    <a href="./index.html">Volver a Index</a>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
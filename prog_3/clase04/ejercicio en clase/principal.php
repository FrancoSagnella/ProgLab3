<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio</title>
    </head>
    <body>
        <?php
            session_start();
            
            if(isset($_SESSION))
                header("location: ./nexo.php");

            echo "<h1> $_SESSION[legajo] </h1>";
            echo "<h2> $_SESSION[nombre] $_SESSION[apellido] </h2>";
        ?>

        <table>
            <tr>Todos los usuarios</tr>
            <?php

                $fp = fopen("./archivos/alumnos.txt", "r");
                while(!feof($fp))
                {
                    $stringAux = fgets($fp);
                    $stringAux = trim($stringAux);
                    echo "<tr>$stringAux</tr>";
                }
                fclose($fp);

            ?>
        </table>
        
    </body>
</html>

    
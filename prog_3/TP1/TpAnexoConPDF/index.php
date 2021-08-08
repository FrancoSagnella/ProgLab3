<?php
                session_start();
                if(isset($_SESSION['DNIEmpleado']))
                {
                    $_SESSION = array();
                }
        ?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf 8" />
        <title>HTML5 -  Seleccion de TP</title>
        
    </head>
    <body>
        <table>
            <thead>
                <tr><h2>Elegir version</h2></tr>
            </thead>
                <tr>
                    <td><a href="./VersionArchivos/index.php"><h4>Ir a la version con Archivos</h4></a></td>
                    <td><a href="./VersionBD/index.php"><h4>Ir a la version con Base de Datos</h4></a></td>
                    <td><a href="./VersionBDPDF/index.php"><h4>Ir a la version con PDF</h4></a></td>
                </tr>
        </table>
    </body>
</html>
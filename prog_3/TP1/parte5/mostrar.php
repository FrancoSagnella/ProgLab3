<!DOCTYPE html>
<html>

<head>
    <meta charset="utf 8" />
    <title>HTML5 - Listado de Empleados</title>
    <script src="./javascript/funciones.js" ></script>
    <?php 
        require_once ("./backend/validarSesion.php");
    ?>
</head>

<body>
    <h2>Listado de Empleados</h2>
    <!--NUEVO FORM PARA ENVIAR EL MODIFICAR A INDEX-->
    <form action="./index.php" method="POST" id="formMod">
        <input type="hidden" name="hiddenMod" id="hiddenMod" />
    </form>
    <!--NUEVO FORM PARA ENVIAR EL MODIFICAR A INDEX-->
    <table>
        <!--TABLE HEAD-->
        <thead>
            <tr>
                <td colspan="3" >
                <h4>Info</h4>                    
                </td>
            </tr>
            <tr>
                <td colspan="3" ><hr /></td>
            </tr>
        </thead>

        <!--TABLE BODY-->
        <tbody>
            <?php
            require_once ("./clases/fabrica.php");

            $fabrica = new Fabrica('Mi fabrica', 7);
            $fabrica->traerDeArchivo("archivos/empleados.txt");

            foreach($fabrica->getEmpleados() as $value)
            {
                echo "<tr>";
                    echo "<td>";
                        echo $value->toString();
                    echo "</td>";
                    echo "<td>";
                        $src = $value->getPathFoto();
                        echo "<img src=$src width=90 height=90 />";
                    echo "</td>";
                    echo "<td>";
                        ?><a href="eliminar.php?legajo=<?php echo $value->getLegajo(); ?>">Eliminar</a><?php
                    echo "</td>";
                    echo "<td>";
                        echo "<input type='button' name='btnModificar' id='btnModificar' value='modificar' onclick='AdministrarModificar(" . $value->getDni() . ")'/>";
                    echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>

        <!--TABLE FOOT-->
        <tfoot>
            <tr>
                <td colspan="3" ><hr /></td>
            </tr>
            <tr>
                <td colspan="3" >
                    <a href="./index.php">Agregar empleado</a>
                </td>
            </tr>
            <tr>
                <td colspan="3" >
                    <a href="./backend/cerrarSesion.php">Cerrar sesion</a>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
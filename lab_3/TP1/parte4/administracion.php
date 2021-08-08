<?php

require_once ("clases/empleado.php");
require_once ("clases/fabrica.php");

$alta = isset($_POST) ? true : false;

if ($alta) 
{
    define("DNI", $_POST["txtDni"]);
    define("APELLIDO", $_POST["txtApellido"]);
    define("NOMBRE", $_POST["txtNombre"]);
    define("SEXO", $_POST["cboSexo"]);

    define("LEGAJO", $_POST["txtLegajo"]);
    define("SUELDO", $_POST["txtSueldo"]);
    define("TURNO", $_POST["rdoTurno"]);

    $empleado = new Empleado(NOMBRE, APELLIDO, DNI, SEXO, LEGAJO, SUELDO, TURNO);
    $fabrica = new Fabrica("Mi Fabrica", 7);

    $fabrica->traerDeArchivo("archivos/empleados.txt");

    if($fabrica->agregarEmpleado($empleado))
    {
        $fabrica->guardarEnArchivo("archivos/empleados.txt");
        echo "empleado guardado con exito<br/>";

        ?> <a href="./mostrar.php">Mostrar<br/></a>
        <a href="index.html">Volver a Index</a><?php
    }
    else
    {
        echo "El empleado no se pudo agregar al archivo<br/>";
        ?> <a href="./index.html">Volver a Index</a><?php
    }
}
else
{
    echo "El empleado no se pudo agregar al archivo<br/>";
    ?> <a href="./index.html">Volver a Index</a><?php
}


<?php
require_once("../clases/empleado.php");
require_once("../clases/fabrica.php");

$accion = isset($_POST['accion']) ? $_POST['accion'] : false;

switch ($accion) {
    case "eliminar":
    define("LEGAJO", $_POST["legajo"]);

    $fabrica = new Fabrica("mi fabrica", 7);
    $fabrica->traerDeArchivo("../archivos/empleados.txt");

    foreach ($fabrica->getEmpleados() as $value) {
        if ($value->getLegajo() == LEGAJO) {
            if (!Eliminar($fabrica, $value)) {
                echo "Error al eliminar el empleado";
            }
            break;
        }
    }
    echo "Empleado eliminado con exito";
    break;
}

function Eliminar($fabrica, $empleado)
{
    $ret = false;
    if ($fabrica->eliminarEmpleado($empleado)) {
        unlink("../".$empleado->getPathFoto());
        //Guardo la fabrica en el archivo, sin el empleado que recien elimine
        $fabrica->guardarEnArchivo("../archivos/empleados.txt");
        $ret = true;
    }
    return $ret;
}

       
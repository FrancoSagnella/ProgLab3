<?php
require_once "clases/persona.php";
require_once "clases/empleado.php";
require_once "clases/fabrica.php";
require_once ("./backend/validarSesion.php");

$empleado1 = new Empleado("Franco", "Sagnella", 44255742, 'M', 110200, 2, "Mañana");
$empleado2 = new Empleado("Jose", "Rodriguez", 44255742, 'M', 123321, 2, "Tarde");
$empleado3 = new Empleado("Marcos", "sadasd", 44255742, 'M', 333221, 3, "Mañana");
$empleado4 = new Empleado("Esteban", "eeeeee", 44255742, 'M', 332213, 2, "Noche");
$empleado5 = new Empleado("Franco", "sssssss", 44255742, 'M', 2233, 1, "Mañana");
$empleado6 = new Empleado("asdasdwq", "sssssss", 44255742, 'M', 2233, 1, "Mañana");

echo $empleado1->toString() . "<br/>";
echo $empleado1->hablar(array("Español", "Ingles")) . "<br/>";


$fabrica1 = new Fabrica("Mi empresa loco");

$fabrica1->eliminarEmpleado($empleado1);

if($fabrica1->agregarEmpleado($empleado1)){
    echo "Se agrego<br/>";
}
$fabrica1->agregarEmpleado($empleado1);
$fabrica1->agregarEmpleado($empleado1);
$fabrica1->agregarEmpleado($empleado1);
$fabrica1->agregarEmpleado($empleado1);
$fabrica1->agregarEmpleado($empleado2);
$fabrica1->agregarEmpleado($empleado3);
$fabrica1->agregarEmpleado($empleado4);
$fabrica1->agregarEmpleado($empleado5);
if($fabrica1->agregarEmpleado($empleado6) == false){
    echo "No se agrego<br/>";
}

echo $fabrica1->toString() . "<br/>";

if($fabrica1->eliminarEmpleado($empleado1)){
    echo "Se elimino<br/>"; 
}
if($fabrica1->eliminarEmpleado($empleado1) == false){
    echo "No se puedo eliminar, no se encuentra en el array<br/>";
}
$fabrica1->eliminarEmpleado($empleado4);

echo $fabrica1->toString() . "<br/>";

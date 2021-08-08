<html>
<?php
require_once "empleado.php"; 
require_once "fabrica.php"; 
if($_POST["guardar"])
{
    $nombre=$_POST["txtNombre"];
$apellido=$_POST["txtApellido"];
$dni=$_POST["txtDni"];
$legajo=$_POST["txtLegajo"];
$sueldo=$_POST["txtSueldo"];
$sexo=$_POST["sexo"];
$turno=$_POST["rdoTurno"];

$empleado=new Empleado($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno);
$fabrica=new Fabrica("test");
 /*if(fputs($fp,$empleado->ToString() . "\r\n"))
{
    fclose($fp);
     echo '<a href="mostrar.php">MOSTRAR </a>';
}

//}
else{
    echo '<a href="index.html">INDEX </a>';
}*/
$fabrica->TraerDeArchivo("./archivos/empleados.txt");
if($fabrica->AgregarEmpleado($empleado))
{
    $fabrica->GuardarEnArchivo("./archivos/empleados.txt");
    echo '<a href="mostrar.php">MOSTRAR </a>';

}
else
{
    echo "Error al ingresar un nuevo empleado" . "<br>";
    echo '<a href="index.html">PAGINA PRINCIPAL </a>';

}
}


?>
</html>

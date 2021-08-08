<?php
require_once "empleado.php"; 
require_once "persona.php"; 
require_once "fabrica.php"; 
//2. Testeo la jerarquia de clases
$empleado1= new Empleado("Rodrigo", "Benitez", 33568741, "m",1,102,"mañana");
$empleado2= new Empleado("Agustina", "Gonzalez", 32542845, "f",2,100,"noche");
$empleado3= new Empleado("Lucas", "Perez", 33665147, "m",3,105,"mañana");
$empleado4= new Empleado("Lucas", "Perez", 33665147, "m",3,105,"mañana");
$empleado5= new Empleado("Alison", "Ossa", 33645788, "m",3,110,"noche");
//$empleado6= new Empleado("Anahi", "Rodriguez", 336651475, "m",3,105,"mañana");

//3. Testeo la modificacion del diagrama de clases
$fabrica= new Fabrica("Restaurante McDonald's S.A");

echo $empleado1->Hablar($idioma[]=["Ingles" , "Español"]);
echo $empleado1->ToString();

echo $empleado2->Hablar($idioma[]=["Ingles" , "Francés"]);
echo $empleado2->ToString();

echo $empleado3->Hablar($idioma[]=["Ingles" , "Francés", "Español"]);
echo $empleado3->ToString();

echo $empleado4->Hablar($idioma[]=["Ingles"]);
echo $empleado4->ToString();

echo $empleado5->Hablar($idioma[]=["Español" , "Francés"]);
echo $empleado5->ToString();

echo $fabrica->AgregarEmpleado($empleado1) . "<br>";//hago los echos para saber
echo $fabrica->AgregarEmpleado($empleado2) . "<br>";//que se ingresaron bien
echo $fabrica->AgregarEmpleado($empleado3) . "<br>";//los empleados.
echo $fabrica->AgregarEmpleado($empleado4) . "<br>";//muestra 1 para saber que 
echo $fabrica->AgregarEmpleado($empleado5) . "<br>";//habia lugar y lo ingreso. caso contrario no muestra nada
//echo $fabrica->AgregarEmpleado($empleado6) . "<br>";

echo $fabrica->CalcularSueldos() . "<br>";
echo $fabrica->ToString() . "<br>";
echo $fabrica->EliminarEmpleado($empleado1) . "<br>";
echo $fabrica->ToString();

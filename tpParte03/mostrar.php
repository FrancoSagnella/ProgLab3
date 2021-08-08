<?php
require_once "empleado.php"; 

$fp=fopen("./archivos/empleados.txt","r");
$i=0;
while(!feof($fp) )
{
    /*if(feof($fp))
    {
        break;
    }*/

    
    $contenido=fgets($fp);
    $empleado=trim($contenido);
    if($contenido=="")
    {
        break;
    }
    $empleado=explode(" - ",$contenido);
    ;//podria hacer una for donde 0 lo remplazo por i
    if($empleado!=""   );
    {
        
        $nuevoEmpleado=new Empleado($empleado[0],$empleado[1],$empleado[2],$empleado[3],$empleado[4],$empleado[5],$empleado[6]);
        $legajoAux= $nuevoEmpleado->GetLegajo();
        echo $nuevoEmpleado->ToString() . "  " . "<a href=eliminar.php?legajo=$legajoAux>Eliminar</a>" ."<br>";
        
        //$i++;
       // echo $i . "<br>";
       // echo "<pre>" .  var_dump($empleado ) . "</pre>";
        //echo isset($empleado[1]) . "------";
    }
}
fclose($fp);
?>
<a href="index.html">INDEX<br/></a><?php    

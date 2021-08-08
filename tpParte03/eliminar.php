<?php
require_once "empleado.php"; 
require_once "fabrica.php"; 

$legajoEliminar=$_GET["legajo"];
$encontro=false;
$fp=fopen("./archivos/empleados.txt","r");
//echo $legajoEliminar . "---";
while(!feof($fp) )
{
    
    $contenido=fgets($fp);
     $empleadoEliminar=trim($contenido);
    if($contenido=="")
    {
        break;
    }
    $empleadoEliminar=explode(" - ",$contenido);

    //echo $empleadoEliminar[4 ]. "<br>";

    if($empleadoEliminar!="" && isset($empleadoEliminar[1])==true );
    {
        if($empleadoEliminar[4]==$legajoEliminar)
        {

            $encontro=true;
          $nuevoEmpleado=new Empleado($empleadoEliminar[0],$empleadoEliminar[1],$empleadoEliminar[2],$empleadoEliminar[3],$empleadoEliminar[4],$empleadoEliminar[5],$empleadoEliminar[6]);
         // echo $nuevoEmpleado->ToString();
            $nuevaFabrica=new Fabrica("test");
            $nuevaFabrica->TraerDeArchivo("./archivos/empleados.txt");
            if($nuevaFabrica->EliminarEmpleado($nuevoEmpleado))
            {
                  //  echo "<pre>" .  var_dump($nuevaFabrica->ToString() ) . "</pre>";
                  //echo $nuevaFabrica->ToString();
                echo "Se borro correctamente";
                $nuevaFabrica->GuardarEnArchivo("./archivos/empleados.txt");
                echo '<a href="mostrar.php">Mostrar<br/></a>';
             echo '<a href="index.html">Pagina principal<br/></a>';  
             break;
            }
            else
            {
                echo "Error, no se logro borrar al empleado";
                echo '<a href="mostrar.php">Mostrar<br/></a>';
             echo '<a href="index.html">Pagina principal<br/></a>';  
             break;
            }


        }
        
        
    }
}
       if($encontro==false)
        {
            echo "No puedo eliminar al empleado";
            echo '<a href="mostrar.php">Mostrar<br/></a>';
             echo '<a href="index.html">Pagina principal<br/></a>';  
            
        }
fclose($fp);
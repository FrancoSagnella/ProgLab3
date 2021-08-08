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
    define("HIDDEN", $_POST["hdnModificar"]);

    $fotoAux = isset($_FILES['archivo'])? true : false;
    $fotoPath = validarFoto();

    if($fotoAux && $fotoPath != false)
    {
        $empleado = new Empleado(NOMBRE, APELLIDO, DNI, SEXO, LEGAJO, SUELDO, TURNO, $fotoPath);
        $fabrica = new Fabrica("Mi Fabrica", 7);

        $fabrica->traerDeArchivo("archivos/empleados.txt");

        if(HIDDEN == "alta")//Si es para una alta
        {
            if($fabrica->agregarEmpleado($empleado))
            {
                //si se agrego bien el empleado, muevo la foto a donde debo
                move_uploaded_file($_FILES['archivo']['tmp_name'], $fotoPath);
                $fabrica->guardarEnArchivo("archivos/empleados.txt");
                echo "empleado guardado con exito<br/>";

                ?> <a href="./mostrar.php">Mostrar<br/></a>
                <a href="index.php">Volver a Index</a><?php
            }
            else
            {
                echo "El empleado no se pudo agregar<br/>";
                ?> <a href="./index.php">Volver a Index</a><?php
            }
        }
        else//Si el hidden era modificar
        {
            //recorro la fabrica
            foreach($fabrica->getEmpleados() as $value)
            {
                //si se encuentra el empleado a modificar
                if($value->getDni() == DNI)
                {
                    //Lo elimino (con su foto)
                    if($fabrica->eliminarEmpleado($value))
                    {
                        unlink($value->getPathFoto());
                        $fabrica->guardarEnArchivo("./archivos/empleados.txt");

                        //Lo vuelvo a agregar con los datos nuevos
                        $fabrica->agregarEmpleado($empleado);
                        move_uploaded_file($_FILES['archivo']['tmp_name'], $fotoPath);
                        $fabrica->guardarEnArchivo("archivos/empleados.txt");
                        echo "Empleado modificado con exito<br/>";

                        ?> <a href="mostrar.php">Volver a Mostrar<br/></a>
                        <a href="index.php">Volver a Index</a><?php
                    }
                    else
                    {
                        echo "El empleado no se pudo modificar del archivo<br/>";

                        ?> <a href="mostrar.php">Volver a Mostrar<br/></a>
                        <a href="index.php">Volver a Index</a><?php
                    }
                }
            }
        }
        
    }
    else
    {
        echo "El archivo subido no era valido o ya existe<br/>";
        ?> <a href="./index.php">Volver a Index<br/></a>
        <a href="./mostrar.php">Mostrar</a><?php
    }
    
}
else
{
    echo "El empleado no se pudo agregar<br/>";
    ?> <a href="./index.php">Volver a Index</a><?php
}



function validarFoto()
{
    $newPath = false;
    $tempPath = "./fotos/" . $_FILES["archivo"]["name"];

    $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
    if($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif" || $extension == "bmp")
    {
        $_FILES["archivo"]["name"] = DNI . "-". APELLIDO . "." . $extension;
        $newPath = "./fotos/" . $_FILES["archivo"]["name"];

        if( !(!(file_exists($newPath)) && getimagesize($_FILES['archivo']['tmp_name']) != false && $_FILES['archivo']['size'] <= 1000000))
        {
            $newPath = false;
        }
    }
    return $newPath;
}


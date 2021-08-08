<?php
    $bool = isset($_POST) ? true : false;

    if($bool)
    {
        $dni = $_POST['txtDni'];
        $apellido = $_POST['txtApellido'];

        if(empleadoExists("./../archivos/empleados.txt", $dni, $apellido))
        {
            session_start();
            $_SESSION['DNIEmpleado'] = $dni;

            header("location: ./../mostrar.php");
        }
        else
        {
            echo "Datos invalidos";
            ?> <a href="./../login.html">Volver a Login</a><?php
        }
    }

    function empleadoExists($path, $dni, $apellido)
    {
        $exists = false;

        $f = fopen($path, "r");

        while(!feof($f))
        {
            $stringAux = fgets($f);
            $stringAux = trim($stringAux);

            if($stringAux != "")
            {
                $arrayAux = explode(" - ", $stringAux);
                if($arrayAux[1] == $apellido && $arrayAux[2] == $dni)
                {
                    $exists = true;
                    break;
                }
            }
        }

        fclose($f);

        return $exists;
    }
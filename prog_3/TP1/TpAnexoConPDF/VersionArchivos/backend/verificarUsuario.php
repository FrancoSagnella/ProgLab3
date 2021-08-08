<?php
    $bool = isset($_POST) ? true : false;

    if($bool)
    {
        $dni = $_POST['dni'];
        $apellido = $_POST['apellido'];

        if(empleadoExists("./../archivos/login.txt", $dni, $apellido))
        {
            session_start();
            $_SESSION['DNIEmpleado'] = $dni;

            echo "Ha iniciado sesion correctamente";
            //header("location: ./../index.php");
        }
        else
        {
            echo "Datos invalidos";
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
<?php
    $accion = isset($_POST['accion']) ? $_POST['accion'] : NULL;

    //declaro variables con los valores para conectarme a la bd
    $host = "localhost";
    $user = "root";
    $pass = "";
    $base = "usuarios_test";

    //hago el switch para evaluar el caso de la accion que me llego por post
    switch($accion)
    {
        case "login" :

            //Establezco la coneccion con la base de datos
            $con = @mysqli_connect($host, $user, $pass, $base);
            //Declaro la instruccion que voy a ejecutar
            $sql = "SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.perfil WHERE correo LIKE '$_POST[correo]' AND clave LIKE '$_POST[clave]'";
            //Ejecuto la instruccion sobre la base de datos
            $rs = $con->query($sql);

            //Voy leyendo todas las filas que lei (se guardaron el $rs) y las devuelvo como un array asociativo a la variable $row
            while ($row = $rs->fetch_assoc())
            { 
                //guardo en la variable user_array todos los arrays con los datos de cada fila
                //que lei de la bd
                $user_array[] = $row;
            }

            if(isset($user_array))
            {
                //Recorro cada usuario que coincidio y termine trayendo
                foreach($user_array as $usuario)
                {
                    //Muestro el nombre del usuario junto con la descripcion de su perfil
                    echo $usuario['nombre'] . " - " . $usuario['descripcion'];
                    echo "<br/>";
                }
            }
            else
            {
                echo "El usuario que se intento bsucar no existe";
            }

            //Cierro la coneccion con la bd
            mysqli_close($con);
            break;

        case "mostrar" :

            $con = @mysqli_connect($host, $user, $pass, $base);
            $sql = "SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.perfil";
            $rs = $con->query($sql);

            while ($row = $rs->fetch_assoc())
            { 
                $user_array[] = $row;
            }

            if(isset($user_array))
            {
                foreach($user_array as $usuario)
                {
                    echo "<pre>$usuario[id] - $usuario[correo] - $usuario[clave] - $usuario[nombre] - $usuario[perfil] - $usuario[descripcion]";
                    echo "</pre>";
                }
            }
            break;
        default:
            echo "Meteme una accion valida pa";
    }
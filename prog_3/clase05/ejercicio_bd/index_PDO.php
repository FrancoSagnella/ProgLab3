<?php
    $accion = isset($_POST['accion']) ? $_POST['accion'] : NULL;

    $user = "root";
    $pass = "";
    $parametros=array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    $pdo = new PDO('mysql:host=localhost;dbname=usuarios_test;charset=utf8', $user, $pass, $parametros);

    switch($accion)
    {
        case "login" :
            try{
                if(!(isset($_POST['correo'])) || !(isset($_POST['clave'])))
                    throw new Exception("No se recibieron los parametros solicitados");

            $sentencia = $pdo->prepare("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.perfil WHERE correo LIKE '$_POST[correo]' AND clave LIKE '$_POST[clave]'");
            $sentencia->execute();

            while ($row = $sentencia->fetch(PDO::FETCH_ASSOC))
            { 
                $user_array[] = $row;
            }

            if(isset($user_array))
            {
                foreach($user_array as $usuario)
                {
                    echo $usuario['nombre'] . " - " . $usuario['descripcion'];
                    echo "<br/>";
                }
            }
            else
            {
                echo "El usuario que se intento bsucar no existe";
            }
        }
        catch(Exception $e)
        {
            echo "Error en login: ".$e->getMessage();
        }
            break;

        case "mostrar" :
            try{

            $sentencia = $pdo->prepare("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.perfil");
            $sentencia->execute();

            while ($row = $sentencia->fetch(PDO::FETCH_ASSOC))
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
        }
        catch(Exception $e)
        {
            echo "Error al mostrar: ".$e->getMessage();
        }
            break;
        case "alta":
            try
            {
                $obj = isset($_POST['obj_json']) ? json_decode($_POST['obj_json']) : throw new PDOException("No se recibio el empleado por post");
                $correo = $obj->correo;
                $clave = $obj->clave;
                $nombre = $obj->nombre;
                $perfil = $obj->perfil;

                $sentencia = $pdo->prepare("INSERT INTO usuarios (correo, clave, nombre, perfil) VALUES (:correo, :clave, :nombre, :perfil)");

                $sentencia->bindValue(":correo", $correo, PDO::PARAM_STR);
                $sentencia->bindValue(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $sentencia->bindValue(":perfil", $perfil, PDO::PARAM_INT);

                if(!$sentencia->execute())
                {
                    throw new PDOException("No se pudo ejecutar la sentencia");
                }
                else{
                    echo "usuario agregado con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error al ejecutar alta: ".$e->getMessage();
            }
            break;
        case "baja":
            try
            {
                $id = isset($_POST['id']) ? $_POST['id'] : throw new PDOException("No se recibio el id del usuario");

                $sentencia = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");

                $sentencia->bindValue(":id", $id, PDO::PARAM_INT);

                if(!$sentencia->execute())
                {
                    throw new PDOException("No se pudo ejecutar la sentencia");
                }
                else{
                    echo "usuario eliminado con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error al ejecutar modificacion: ".$e->getMessage();
            }
            break;
        case "modificacion":
            try
            {
                $id = isset($_POST['id']) ? $_POST['id'] : throw new PDOException("No se recibio el id del usuario");
                $obj = isset($_POST['obj_json']) ? json_decode($_POST['obj_json']) : throw new PDOException("No se recibio el usuario por post");
                $correo = $obj->correo;
                $clave = $obj->clave;
                $nombre = $obj->nombre;
                $perfil = $obj->perfil;

                $sentencia = $pdo->prepare("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, perfil = :perfil WHERE id = :id");

                $sentencia->bindValue(":id", $id, PDO::PARAM_INT);
                $sentencia->bindValue(":correo", $correo, PDO::PARAM_STR);
                $sentencia->bindValue(":clave", $clave, PDO::PARAM_STR);
                $sentencia->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $sentencia->bindValue(":perfil", $perfil, PDO::PARAM_INT);

                if(!$sentencia->execute())
                {
                    throw new PDOException("No se pudo ejecutar la sentencia");
                }
                else{
                    echo "usuario modificado con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error al ejecutar modificacion: ".$e->getMessage();
            }
            break;
        default:
            echo "Meteme una accion valida";
    }
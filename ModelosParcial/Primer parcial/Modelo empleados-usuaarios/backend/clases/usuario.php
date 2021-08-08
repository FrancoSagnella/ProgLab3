<?php
require_once "accesodatos.php";
require_once "IBM.php";
class Usuario implements IBM
{
    public $id;
    public $nombre;
    public $correo;
    public $clave;
    public $id_perfil;
    public $perfil;

    public function __construct($id = null, $nombre, $correo, $clave, $id_perfil = null, $perfil = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->id_perfil = $id_perfil;
        $this->perfil = $perfil;
    }

    public function ToJSON()
    {
        return json_encode(array('nombre' => $this->nombre, 'correo' => $this->correo, 'clave' => $this->clave));
    }

    public function GuardarEnArchivo()
    {
        $ret = new stdClass();
        $ret->exito = true;
        $ret->mensaje = "Se escribio en el archivo con exito";

        if (!file_put_contents("./archivos/usuarios.json", $this->ToJSON() . "\n", FILE_APPEND)) {
            $ret->exito = false;
            $ret->mensaje = "No se pudo escribir en el archivo";
        }
        return json_encode($ret);
    }

    public static function TraerTodosJSON()
    {
        $ret = array();
        $f = fopen("./archivos/usuarios.json", "r");

        while (!feof($f)) {
            $line = trim(fgets($f));
            $usuario = json_decode($line);
            if ($line != null)
                array_push($ret, new Usuario(null, $usuario->nombre, $usuario->correo, $usuario->clave));
        }
        fclose($f);
        return $ret;
    }

    public function Agregar()
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, id_perfil) VALUES (:correo, :clave, :nombre, :id_perfil)");

            $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    public static function TraerTodos()
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.id_perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.id_perfil");
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $user_array[] = new Usuario($row['id'], $row['nombre'], $row['correo'], $row['clave'], $row['id_perfil'], $row['descripcion']);
            }

            if (isset($user_array)) {
                return $user_array;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function TraerUno($params)
    {
        $obj = json_decode($params);
        if (!isset($obj))
            return false;

        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.id_perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.id_perfil WHERE usuarios.correo = :correo AND usuarios.clave = :clave");

            $consulta->bindValue(":correo", $obj->correo);
            $consulta->bindValue(":clave", $obj->clave);

            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $user = new Usuario($row['id'], $row['nombre'], $row['correo'], $row['clave'], $row['id_perfil'], $row['descripcion']);
            }

            if (isset($user)) {
                return $user;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function DevolverUsuarioSinClave(){
        $userSinClave = new stdClass();
        $userSinClave->id = $this->id;
        $userSinClave->nombre = $this->nombre;
        $userSinClave->correo = $this->correo;
        $userSinClave->id_perfil = $this->id_perfil;
        $userSinClave->perfil = $this->perfil;

        return $userSinClave;
    }

    public static function DevolverArrayUsuariosSinClave($user_array){
        $userArraySinClave = array();

        foreach($user_array as $user){
            array_push($userArraySinClave, $user->DevolverUsuarioSinClave());
        }

        return $userArraySinClave;
    }

    public function Modificar(){
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil WHERE id = :id");

            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }
    public static function Eliminar($id){
        $ret = false;
        try{
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");

            $consulta->bindValue(":id", $id, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        }catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }
}

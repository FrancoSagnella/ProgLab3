<?php
require_once "ICRUD.php";
require_once "usuario.php";

class Empleado extends Usuario implements ICRUD
{
    public $foto;
    public $sueldo;

    public function __construct($id, $nombre, $correo, $clave, $id_perfil, $perfil, $foto, $sueldo)
    {
        parent::__construct($id, $nombre, $correo, $clave, $id_perfil, $perfil);
        $this->foto = $foto;
        $this->sueldo = $sueldo;
    }
    public static function TraerUno($params)
    {
        $obj = json_decode($params);
        if (!isset($obj))
            return false;

        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT empleados.id, empleados.correo, empleados.clave, empleados.nombre, empleados.id_perfil, empleados.foto, empleados.sueldo, perfiles.descripcion FROM `empleados` INNER JOIN `perfiles` ON perfiles.id=empleados.id_perfil WHERE empleados.correo = :correo AND empleados.clave = :clave");
            $consulta->bindValue(":correo", $obj->correo);
            $consulta->bindValue(":clave", $obj->clave);

            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $emp = new Empleado($row['id'], $row['nombre'], $row['correo'], $row['clave'], $row['id_perfil'], $row['descripcion'], $row['foto'], $row['sueldo']);
            }

            if (isset($emp)) {
                return $emp;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public static function TraerUnoId($id){
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT empleados.id, empleados.correo, empleados.clave, empleados.nombre, empleados.id_perfil, empleados.foto, empleados.sueldo, perfiles.descripcion FROM `empleados` INNER JOIN `perfiles` ON perfiles.id=empleados.id_perfil WHERE empleados.id = :id");
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);

            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $emp = new Empleado($row['id'], $row['nombre'], $row['correo'], $row['clave'], $row['id_perfil'], $row['descripcion'], $row['foto'], $row['sueldo']);
            }

            if (isset($emp)) {
                return $emp;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public static function TraerTodos()
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT empleados.id, empleados.correo, empleados.clave, empleados.nombre, empleados.id_perfil, empleados.foto, empleados.sueldo, perfiles.descripcion FROM `empleados` INNER JOIN `perfiles` ON perfiles.id=empleados.id_perfil");
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $empl_array[] = new Empleado($row['id'], $row['nombre'], $row['correo'], $row['clave'], $row['id_perfil'], $row['descripcion'], $row['foto'], $row['sueldo']);
            }

            if (isset($empl_array)) {
                return $empl_array;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function Agregar()
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO empleados (correo, clave, nombre, id_perfil, foto, sueldo) VALUES (:correo, :clave, :nombre, :id_perfil, :foto, :sueldo)");

            $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(":sueldo", $this->sueldo, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }
    public function Modificar()
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("UPDATE empleados SET correo = :correo, clave = :clave, nombre = :nombre, id_perfil = :id_perfil, foto = :foto, sueldo = :sueldo WHERE id = :id");

            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(":sueldo", $this->sueldo, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }
    public static function Eliminar($id)
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM empleados WHERE id = :id");

            $consulta->bindValue(":id", $id, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    //Va a devolver el path, si pudo guardar la foto y generar el path, o null si no pudo
    public static function GuardarFoto($nombre, $foto){
        $ret = null;
        if($foto != null){
            $tempPath = "./empleados/fotos/" . $foto["name"];
            $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
            $foto["name"] = $nombre . "." . date("Gis") . "." . $extension;
            $tempPath = "./empleados/fotos/" . $foto["name"];
            $ret = "./backend/empleados/fotos/" . $foto["name"];

            if(!move_uploaded_file($foto["tmp_name"], $tempPath))
                $ret = null;  
        }
        return $ret;
    }
}

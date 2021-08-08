<?php
require_once ("persona.php");
require_once ("AccesoDatos.php");

class Empleado extends Persona
{
    protected $legajo;
    protected $sueldo;
    protected $turno;
    protected $pathFoto;

    public function __construct($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno, $pathFoto)
    {
        parent::__construct($nombre, $apellido, $dni, $sexo);
        $this->legajo = $legajo;
        $this->sueldo = $sueldo;
        $this->turno = $turno;
        $this->pathFoto = $pathFoto;
    }

    public function getLegajo()
    {
        return $this->legajo;
    }
    public function getSueldo()
    {
        return $this->sueldo;
    }
    public function getTurno()
    {
        return $this->turno;
    }
    public function getPathFoto()
    {
        return $this->pathFoto;
    }

    public function hablar($idioma)
    {
        $cadena = "El empleado habla ";
        foreach ($idioma as $value) {
            $cadena .= $value . ", ";
        }
        return $cadena;
    }

    public function toString()
    {
        return parent::toString() . " - " . $this->legajo 
                . " - " . $this->sueldo . " - " . $this->turno . " - " . $this->pathFoto;
    }

    public function AgregarBD()
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO empleados (nombre, apellido, dni, sexo, sueldo, turno, pathFoto) VALUES (:nombre, :apellido, :dni, :sexo, :sueldo, :turno, :pathFoto)");

            $consulta->bindValue(":nombre", $this->getNombre(), PDO::PARAM_STR);
            $consulta->bindValue(":apellido", $this->getApellido(), PDO::PARAM_STR);
            $consulta->bindValue(":dni", $this->getDni(), PDO::PARAM_INT);
            $consulta->bindValue(":sexo", $this->getSexo(), PDO::PARAM_STR);
            $consulta->bindValue(":sueldo", $this->sueldo, PDO::PARAM_INT);
            $consulta->bindValue(":turno", $this->turno, PDO::PARAM_STR);
            $consulta->bindValue(":pathFoto", $this->pathFoto, PDO::PARAM_STR);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    public function ModificarBD()
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("UPDATE empleados SET nombre = :nombre, apellido = :apellido, dni = :dni, sexo = :sexo, sueldo = :sueldo, turno = :turno, pathFoto = :pathFoto WHERE legajo = :legajo");

            $consulta->bindValue(":legajo", $this->legajo, PDO::PARAM_INT);
            $consulta->bindValue(":nombre", $this->getNombre(), PDO::PARAM_STR);
            $consulta->bindValue(":apellido", $this->getApellido(), PDO::PARAM_STR);
            $consulta->bindValue(":dni", $this->getDni(), PDO::PARAM_INT);
            $consulta->bindValue(":sexo", $this->getSexo(), PDO::PARAM_STR);
            $consulta->bindValue(":sueldo", $this->sueldo, PDO::PARAM_INT);
            $consulta->bindValue(":turno", $this->turno, PDO::PARAM_STR);
            $consulta->bindValue(":pathFoto", $this->pathFoto, PDO::PARAM_STR);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    public static function EliminarBD($legajo)
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM empleados WHERE legajo = :legajo");

            $consulta->bindValue(":legajo", $legajo, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }
}

<?php
require_once ("persona.php");

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
}

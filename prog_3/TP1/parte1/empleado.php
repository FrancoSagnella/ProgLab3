<?php

class Empleado extends Persona
{

    protected $legajo;
    protected $sueldo;
    protected $turno;

    public function __construct($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno)
    {
        parent::__construct($nombre, $apellido, $dni, $sexo);
        $this->legajo = $legajo;
        $this->sueldo = $sueldo;
        $this->turno = $turno;
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
        return parent::toString() . " - Legajo: " . $this->legajo 
                . " - Sueldo: " . $this->sueldo . " - Turno: " . $this->turno;
    }
}

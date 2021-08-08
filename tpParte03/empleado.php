<?php
require_once "persona.php"; 
class Empleado extends Persona
{
    private $_legajo;
    private $_sueldo;
    private $_turno;
    
    public function __construct($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno)
    {
        parent::__construct($nombre,$apellido,$dni,$sexo);
        $this->_legajo=$legajo;
        $this->_sueldo=$sueldo;
        $this->_turno=$turno;        
    }
    public function GetLegajo()
    {
        return $this->_legajo;
    }
    public function GetSueldo()
    {
        return $this->_sueldo;
    }
    public function GetTurno()
    {
        return $this->_turno;
    }

    public function Hablar($idioma)
    {
        return "El empleado habla " . implode(", ", $idioma)."<br/>";
    }
    public function ToString()
    {

        return  parent::ToString() . " - " . $this->_legajo
        . " - " . $this->_sueldo . " - " . $this->_turno;

    }
}
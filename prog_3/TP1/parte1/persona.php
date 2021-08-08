<?php

abstract class Persona
{

    private $apellido;
    private $dni;
    private $nombre;
    private $sexo;

    public function __construct($nombre, $apellido, $dni, $sexo)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->sexo = $sexo;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function getApellido()
    {
        return $this->apellido;
    }
    public function getDni()
    {
        return $this->dni;
    }
    public function getSexo()
    {
        return $this->sexo;
    }

    public abstract function hablar($idioma);

    public function toString()
    {
        return "Nombre: " . $this->nombre . " - Apellido: " . $this->apellido .
            " - Dni: " . $this->dni . " - Sexo: " . $this->sexo;
    }
}

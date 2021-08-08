<?php

class Fabrica
{
    private $cantMaxima;
    private $empleados;
    private $razonSocial;

    public function __construct($razonSocial)
    {
        $this->razonSocial = $razonSocial;
        $this->cantMaxima = 5;
        $this->empleados = array();
    }

    public function agregarEmpleado($empleado)
    {
        $retorno = false;
        if (count($this->empleados) < $this->cantMaxima) {
            array_push($this->empleados, $empleado);
            $this->eliminarEmpleadoRepetido();
            $retorno = true;
        }
        return $retorno;
    }

    public function eliminarEmpleado($empleado)
    {
        $retorno = false;
        foreach ($this->empleados as $key => $value) {
            if ($value === $empleado) {
                unset($this->empleados[$key]);
                $retorno = true;
                break;
            }
        }
        return $retorno;
    }

    private function eliminarEmpleadoRepetido()
    {
        //Tengo que usar SORT_REGULAR para que le compare los elementos como tal,
        //Sino me los trata como strings
        $this->empleados = array_unique($this->empleados, SORT_REGULAR);
    }

    public function toString()
    {
        $retorno = "Razon Social:" . $this->razonSocial .
                    "<br/>Cantidad maxima de empleados: " . $this->cantMaxima . 
                    "<br/>Cantidad actual de empleados: " . count($this->empleados) . 
                    "<br/>Lista de empleados:";
        
        foreach($this->empleados as $value){
            $retorno .= ("<br/>" . $value->toString()); 
        }

        $retorno .= "<br/>Total abonado en sueldos: " . $this->calcularSueldos();

        return $retorno;
    }

    public function calcularSueldos(){
        $acum = 0;
        foreach($this->empleados as $value){
            $acum+=$value->getSueldo();
        }
        return $acum;
    }
}

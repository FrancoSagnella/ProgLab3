<?php

    require_once ("empleado.php");
    require_once ("interfaces.php");

class Fabrica implements iArchivo
{
    private $cantMaxima;
    private $empleados;
    private $razonSocial;

    public function __construct($razonSocial, $cantMaxima = 5)
    {
        $this->razonSocial = $razonSocial;
        $this->cantMaxima = $cantMaxima;
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
            if ($value == $empleado) {
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

    public function guardarEnArchivo($nombreArchivo)
    {
        $f = fopen($nombreArchivo, "w");

        foreach($this->empleados as $value)
        {
            fputs($f, $value->toString() . "\r\n");
        }

        fclose($f);
    } 

    public function traerDeArchivo($nombreArchivo)
    {
        $f = fopen($nombreArchivo, "r");

        while(!feof($f))
        {
            $stringAux = fgets($f);
            $stringAux = trim($stringAux);

            if($stringAux != "")
            {
                $arrayAux = explode(" - ", $stringAux);
                $empleado = new Empleado($arrayAux[0], $arrayAux[1], $arrayAux[2], $arrayAux[3], $arrayAux[4], $arrayAux[5], $arrayAux[6]);

                $this->agregarEmpleado($empleado);  
            }
        }

        fclose($f);
    }
}

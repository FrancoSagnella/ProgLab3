<?php

    require_once ("empleado.php");

class Fabrica
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

    public function getEmpleados()
    {
        return $this->empleados;
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

    public function actualizarBD()
    {
        $ret = true;
        foreach($this->empleados as $value)
        {
            if($this->traerUnoBD($value->getLegajo()) != false)
            {
                if(!$value->ModificarBD())
                {
                    $ret = false;
                    break;
                }
                    
            }
            else
            {
                if(!$value->AgregarBD())
                {
                    $ret = false;
                    break;
                }
            }
        }

        return $ret;
    }

    public function traerDeBD()
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT nombre, apellido, dni, sexo, legajo, sueldo, turno, pathFoto FROM empleadosPDF");
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $emp = new Empleado($row['nombre'], $row['apellido'], $row['dni'], $row['sexo'], $row['legajo'], $row['sueldo'], $row['turno'], $row['pathFoto']);
                $this->agregarEmpleado($emp);
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function traerUnoBD($legajo)
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT nombre, apellido, dni, sexo, legajo, sueldo, turno, pathFoto FROM empleadosPDF WHERE legajo = :legajo");
            $consulta->bindValue(":legajo", $legajo, PDO::PARAM_INT);

            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $emp = new Empleado($row['nombre'], $row['apellido'], $row['dni'], $row['sexo'], $row['legajo'], $row['sueldo'], $row['turno'], $row['pathFoto']);
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
}

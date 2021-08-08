<?php
require_once "empleado.php"; 
require_once "interfaces.php"; 

class Fabrica implements IArchivo
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razonSocial;

    function __construct($razonSocial , $cantidad=7)
    {
        $this->_razonSocial=$razonSocial;
        $this->_empleados=[];
        $this->_cantidadMaxima=$cantidad;
    }

    public function AgregarEmpleado($emp)
    {
        $retorno=false;
        if($this->_cantidadMaxima>count($this->_empleados))
        {
             array_push($this->_empleados,$emp);
             
             $this->EliminarEmpleadoRepetido();
        $retorno=true;
        }
        else
        {
            echo "No hay mas espacio para agregar mas empleados";
        }
       return $retorno;
     }

    public function CalcularSueldos()
    {
        $total=0;
        foreach($this->_empleados as $sueldo)
        {
            $total+=$sueldo->GetSueldo();
           
        }
        return $total;
    }

    public function EliminarEmpleado($emp)
    {
        $retorno=false;
        if(array_search($emp,$this->_empleados)>-1)
        {
            unset($this->_empleados[array_search($emp,$this->_empleados)]);
            $retorno=true;
        }
        else
        {
            echo "No existe ese empleado";
        }
        return $retorno;
    }

    private function EliminarEmpleadoRepetido()
    {
       // var_dump(array_unique($this->_empleados, $sort_flags = SORT_REGULAR )) ;
       $this->_empleados =array_unique($this->_empleados, SORT_REGULAR);

    }

    public function ToString()
    {
        $cadena="";
        $cadena.="Cantidad maxima de empleados = " . (String)$this->_cantidadMaxima;
        $cadena.=" - Razon social = " . $this->_razonSocial . " <br> ";
        foreach($this->_empleados as $emp)
        {
             $cadena.=$emp->ToString();
        }
        return $cadena;
    }
    public function TraerDeArchivo($nombreArchivo)
    {
        $fp=fopen($nombreArchivo,"r");

        while(!feof($fp) )
        {
             $contenido=fgets($fp);
              $empleado=trim($contenido);

            if($contenido=="")
            {
                 break;
            }
            $empleado=explode(" - ",$empleado);
            if($empleado!="" && isset($empleado[1])==true );
            {
        
              $nuevoEmpleado=new Empleado($empleado[0],$empleado[1],$empleado[2],$empleado[3],$empleado[4],$empleado[5],$empleado[6]);
               $this->AgregarEmpleado($nuevoEmpleado);
            }
        }
        fclose($fp);
    }
    public function GuardarEnArchivo($nombreArchivo)
    {
        $fp = fopen($nombreArchivo,"w");
        //$i=0;
       foreach($this->_empleados as $empleado)
        {
            $empleado=$empleado->ToString();
            $empleado=trim($empleado);

            fwrite($fp,$empleado . "\r\n");
            //$i++;
            //echo $i . "----" . count($this->_empleados)-1 ."<br>"  ;
            
           /* if($i==count($this->_empleados) && $i>1)
            {
                $cadena=$empleado->ToString();
            fwrite($fp, "\r\n" . $cadena );
            }
            else
            {
                
            }*/
        }
      /*  for ($i=0; $i < count($this->_empleados); $i++) { 
            if($i==count($this->_empleados)-1)
            {
                fwrite($fp,"\n" . $this->_empleados[$i]->ToString());
            }
            else
            {
                fwrite($fp,$this->_empleados[$i]->ToString());

            }
            
        }*/
        fclose($fp);
    }
    
}

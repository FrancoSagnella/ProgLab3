<?php
    class Cocinero{
        private $especialidad;
        private $email;
        private $clave;

        public function __construct($especialidad, $email, $clave){
            $this->especialidad=$especialidad;
            $this->email = $email;
            $this->clave = $clave;
        }

        public function ToJSON(){
            
            return json_encode(array('especialidad' => $this->especialidad, 'email' => $this->email, 'clave' => $this->clave));
        }

        public function GuardarEnArchivo(){

        $ret = new stdClass();
        $ret->exito = true;
        $ret->mensaje = "Se escribio en el archivo con exito";

        if (!file_put_contents("./archivos/cocineros.json", $this->ToJSON() . "\n", FILE_APPEND)) {
            $ret->exito = false;
            $ret->mensaje = "No se pudo escribir en el archivo";
        }

        return json_encode($ret);
        }

        public static function TraerTodos(){
            $lista = array();
            $archivo = fopen("./archivos/cocineros.json", "r");
            while(!feof($archivo)){
                $line = trim(fgets($archivo));
                if($line != null){
                    $cocinero = json_decode($line);
                    array_push($lista, new Cocinero($cocinero->especialidad,$cocinero->email,$cocinero->clave));    
                }
            }
            fclose($archivo);

            return $lista;
        }

        public static function VerificarExistencia($cocinero){
            $ret = new stdClass();
            $ret->exito = false;
            $ret->mensaje = 'La lista de cocineros estaba vacia';
            
            $contNombres = array();
            $contEspecialidad = 0;
            $especialidadAux = null;
    
            $arrayCocineros = Cocinero::TraerTodos();
    
            foreach($arrayCocineros as $coc)
            {
                if($coc->email === $cocinero->email && $coc->clave === $cocinero->clave)
                {
                    $ret->exito = true;   
                    $especialidadAux = $coc->especialidad;
                }  
    
                if(!isset($contNombres[$coc->especialidad]))
                {
                    $contNombres[$coc->especialidad] = 1;
                }
                else{
                    $contNombres[$coc->especialidad]++;
                }
            }
            
    
            if($ret->exito === true)
            {
                foreach($arrayCocineros as $coc)
                {
                    if($coc->especialidad === $especialidadAux)
                    {
                        $contEspecialidad++; 
                    }
                }
                $ret->mensaje = "El cocinero existe, hay ".$contEspecialidad." cocineros con la misma especialidad";
            }
            else
            {
                $aux = 0;
                foreach($contNombres as $especialidad => $cantidad)
                {
                    if($cantidad > $aux)
                    {
                        $ret->mensaje = "El cocinero NO existe, las especialidades mas populares son: ".$especialidad.", apareciendo ".$cantidad." veces";
                        $aux = $cantidad;
                    }
                    else if($cantidad == $aux && $aux != 0)
                    {
                        $ret->mensaje .= ", ".$especialidad.", apareciendo ".$cantidad." veces";
                    }
                }
            }
            return json_encode($ret);
        }

        public static function ObtenerEspecialidad($cocinero)
        {
            $cocineros_array = Cocinero::TraerTodos();
            foreach($cocineros_array as $aux)
            {
                if($aux->email === $cocinero->email && $aux->clave === $cocinero->clave)
                {
                    $especialidad = $aux->especialidad;
                    break;
                }
            }

            return $especialidad;
        }
    }
?>
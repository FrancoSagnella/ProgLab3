<?php
    class Cocinero{
        private $especialidad;
        private $email;
        private $clave;

        public function __construct($especialidad,$email, $clave){
            $this->especialidad=$especialidad;
            $this->email = $email;
            $this->clave = $clave;
        }

        public function ToJSON(){
            
            return '{"especialidad": "'. $this->especialidad . '","email": "'. $this->email . '", "clave": "'. $this->clave . '"}';
        }

        public function GuardarEnArchivo(){
            $json = json_decode('{"exito": "", "mensaje": ""}');
            $json->exito = false;
            try{
                $archivo = fopen("./archivos/cocinero.json", "a");
                $cad = fwrite($archivo, $this->ToJSON()."\r\n");
                if($cad > 0 ){
                    $json->exito = true;
                    $json->mensaje = "Se ha podido guardar el cocinero";
                }
                else{
                    $json->mensaje = "No se ha podido guardar el cocinero";
                }
            }
            catch(exception $e){
                echo $json->mensaje = "Error:" . $e->getMessage();
            }
            fclose($archivo);
            
            return $json;
        }

        public static function TraerTodos(){
            $lista = array();
            $archivo = fopen("./archivos/cocinero.json", "r");
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
            $json = json_decode('{"exito": "", "mensaje": ""}');
            $json->exito = false;
            $cont=0;
            
            $lista = Cocinero::TraerTodos();
            
            foreach($lista as $aux){
                if($aux->email == $cocinero->email && $aux->clave == $cocinero->clave){
                    $json->exito = true;
                    $especialidad=$aux->especialidad;
                }
            }
            if ($json->exito) {
                foreach($lista as $aux){
                    if($aux->especialidad==$especialidad){
                        $cont++;
                    }
                }
                $json->mensaje="Cantidad de especialidades:".$cont;
            }

            return $json;
        }


        // public static function VerificarExistencia($cocinero){
        //     $ret = new stdClass();
        //     $ret->existe = false;
        //     $ret->mensaje = 'La lista de cocineros estaba vacia';
            
        //     $contNombres = array();
        //     $contEspecialidad = 0;
        //     $especialidadAux = null;
    
        //     $arrayCocineros = Cocinero::TraerTodos();
    
        //     foreach($arrayCocineros as $coc)
        //     {
        //         if($coc->email === $cocinero->email && $coc->clave === $cocinero->clave)
        //         {
        //             $ret->existe = true;   
        //             $especialidadAux = $coc->especialidad;
        //         }  
    
        //         if(!isset($contNombres[$coc->nombre]))
        //         {
        //             $contNombres[$coc->nombre] = 1;
        //         }
        //         else{
        //             $contNombres[$coc->nombre]++;
        //         }
        //     }
            
    
        //     if($ret->existe === true)
        //     {
        //         foreach($arrayCocineros as $coc)
        //         {
        //             if($coc->especialidad === $especialidadAux)
        //             {
        //                 $contEspecialidad++; 
        //             }
        //         }
        //         $ret->mensaje = "El cocinero existe, hay ".$contEspecialidad." cocineros con la misma especialidad";
        //     }
        //     else
        //     {
        //         $aux = 0;
        //         foreach($contNombres as $nombre => $cantidad)
        //         {
        //             if($cantidad > $aux)
        //             {
        //                 $ret->mensaje = "El cocinero NO existe, las especialidades mas populares son: ".$nombre.", apareciendo ".$cantidad." veces";
        //                 $aux = $cantidad;
        //             }
        //             else if($cantidad == $aux && $aux != 0)
        //             {
        //                 $ret->mensaje .= ", ".$nombre.", apareciendo ".$cantidad." veces";
        //             }
        //         }
        //     }
        //     return json_encode($ret);
        // }
    }
?>
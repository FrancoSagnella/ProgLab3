<?php
    require_once "AccesoDatos.php";
    require_once "IParte1.php";
    require_once "IParte2.php";
    require_once "IParte3.php";

    class Recetas implements IParte1,IParte2,IParte3{
        public $id;
        public $nombre;
        public $ingredientes;
        public $tipo;
        public $pathFoto;

        public function __construct($id = null, $nombre = null,$ingredientes = null, $tipo = null, $pathFoto = null){
            $this->id = $id; 
            $this->nombre = $nombre;
            $this->ingredientes = $ingredientes;
            $this->tipo = $tipo;
            $this->pathFoto = $pathFoto;
        }

        public function ToJSON(){
            return '{"id": "'. $this->id . '", "nombre": "'. $this->nombre . '", "ingredientes": "'. $this->ingredientes . '", "tipo": "'. $this->tipo . '", "pathFoto": "'. $this->pathFoto . '"}';
        }

        public function Agregar(){
            $objetoDatos = AccesoDatos::DameUnObjetoAcceso();
            if($this->pathFoto != null){
                $consulta = $objetoDatos->RetornarConsulta("INSERT INTO recetas (nombre,ingredientes,tipo,path_Foto) VALUES (:nombre, :ingredientes, :tipo, :foto)");
                $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
                //var_dump($this->pathFoto);
            }
            else{
                $consulta = $objetoDatos->RetornarConsulta("INSERT INTO recetas (nombre,ingredientes,tipo) VALUES (:nombre, :ingredientes, :tipo)");
            }
            
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':ingredientes', $this->ingredientes, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $flag = $consulta->execute();
            return $flag;
        }

        public function Traer(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id,nombre, ingredientes, tipo, path_foto as 'pathFoto' FROM recetas");
            
            
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_INTO, new Recetas);    

            return $consulta; 
        }
        public function Existe($recetas)
        {
            $ret=false;
            foreach ($recetas as $aux ) {
                if($aux->nombre == $this->nombre && $aux->tipo==$this->tipo)
                    $ret=true;
            }
            return $ret;
        }
        public function Modificar($id)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE recetas SET nombre=:nombre,ingredientes=:ingredientes,tipo=:tipo,path_foto=:foto WHERE id=:id");
            
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':ingredientes', $this->ingredientes, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
            $consulta->bindValue(':id',$id,PDO::PARAM_INT);
            $flag = false;
            $consulta->execute();
            if($consulta->rowCount() > 0) 
            {
                $flag = true;
            }
           
             return $flag;
        }

        public function Eliminar()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM recetas WHERE nombre=:nombre AND tipo=:tipo");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->execute();
            $flag = false;
            if($consulta->rowCount() > 0){  
                $flag = true;
            }
            return $flag;
        }

        public function GuardarEnArchivo()
        {
            $nombreArchivo = "./recetasBorradas/recetas_borradas.txt";
            $archivo = fopen($nombreArchivo, "a+");
            if ($archivo) {
                $pathFoto = $this->pathFoto;
                $fechaActual = date("h:i:s");
                $fechaActual = str_replace(":", "", $fechaActual);
                $pathviejoM="recetasModificadas/imagenes" . $pathFoto;
                $pathviejoI="recetas/imagenes/" . $pathFoto;
                $imagenTipo = strtolower(pathinfo($pathFoto, PATHINFO_EXTENSION));
                if (file_exists("./recetasModificadas/imagenes" . $pathFoto)) {
                        rename(chop($pathviejoM), chop("./recetasBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo));
                 }
                if (file_exists("./recetas/imagenes/" . $pathFoto)) {
                        rename(chop($pathviejoI), chop("./recetasBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo));
                }
                $this->pathFoto= $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo;
                fwrite($archivo, $this->id . "-" . $this->nombre . "-" . $this->ingredientes . "-" . $this->tipo . "-" . chop($this->pathFoto) . "\r\n");
                fclose($archivo);
            }

        }
        static function MostrarBorrados()
        {
            $archivo = fopen('./recetasBorradas/recetas_borradas.txt', "r");
            $datos = array();
            $listaBorrados = array();
            if ($archivo) {
                $archivito = filesize('./recetasBorradas/recetas_borradas.txt');
                if ($archivito != 0) {
                    while (!feof($archivo)) {
                        $cadena = fgets($archivo);
                        $datos = explode('-', $cadena);
                        if (count($datos) > 2) {
                            $RecetaBorrada = new Recetas($datos[0], $datos[1], $datos[2], $datos[3], $datos[4]);
                            array_push($listaBorrados, $RecetaBorrada);
                        }
                    }
                }
                fclose($archivo);
            }
            return $listaBorrados;
        }
    
    
    
    
    
    }


<?php
    require_once "AccesoDatos.php";
    require_once "IParte1.php";
    require_once "IParte2.php";
    require_once "IParte3.php";

    class Receta implements IParte1{
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
            return json_encode($this);
        }

        public function Agregar(){
            $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO recetas (nombre, ingredientes, tipo, path_foto) VALUES (:nombre, :ingredientes, :tipo, :path_foto)");
    
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(":ingredientes", $this->ingredientes, PDO::PARAM_STR);
                $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
                $consulta->bindValue(":path_foto", $this->pathFoto, PDO::PARAM_STR);
    
                $consulta->execute();
    
                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
        }

        public static function Traer(){
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("SELECT * FROM `recetas`");
                $consulta->execute();
    
                while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $user_array[] = new Receta($row['id'], $row['nombre'], $row['ingredientes'], $row['tipo'], $row['path_foto']);
                }
    
                if (isset($user_array)) {
                    return $user_array;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
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

        public function ExisteId($recetas)
        {
            $ret=false;
            foreach ($recetas as $aux ) {
                if($aux->id == $this->id)
                    $ret=true;
            }
            return $ret;
        }

        public function Modificar()
        {
            $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("UPDATE recetas SET nombre = :nombre, ingredientes = :ingredientes, tipo = :tipo, path_foto = :path_foto WHERE id = :id");

                $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(":ingredientes", $this->ingredientes, PDO::PARAM_STR);
                $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
                $consulta->bindValue(":path_foto", $this->pathFoto, PDO::PARAM_STR);

                $consulta->execute();

                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
        }

        public function Eliminar()
        {
            $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                 $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM recetas WHERE nombre = :nombre AND tipo = :tipo");
    
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);

                $consulta->execute();
    
                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
        }

        public function GuardarEnArchivo()
        {
            $nombreArchivo = "./archivos/recetasBorradas.txt";
            $archivo = fopen($nombreArchivo, "a+");
    
            $pathFoto = $this->pathFoto;
    
            //Si tiene path foto la muevo
            if($pathFoto != null)
            {
                Receta::MoverFoto($pathFoto, $this, 'borrado');
            }
                
            //Lo escribo en formato json
            fwrite($archivo, $this->ToJson() . "\r\n");
    
            fclose($archivo);
        }

        static function MostrarBorrados()
        {
            $ret = array();
            $f = fopen("./archivos/recetasBorradas.txt", "r");
    
            while (!feof($f)) {
                $line = trim(fgets($f));
                $receta = json_decode($line);
                if ($line != null)
                    array_push($ret, new Receta($receta->id, $receta->nombre, $receta->ingredientes, $receta->tipo, $receta->pathFoto));
            }
            fclose($f);
            
            return $ret;
        }

    //Devuelve el nombre que se le puso a la foto, o null si no existe la foto o algo
    public static function GenerarNombreFoto($foto, $nombre, $tipo)
    {
        $ret = null;
        if($foto != null){
        
            $tempPath = $foto["name"];
            $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
            $foto["name"] = $nombre . "." . $tipo . "." . date("Gis") . "." . $extension;
            $ret = $foto["name"];
        
        }
        return $ret;
    }

    public static function MoverFoto($pathFoto, $obj, $accion)
    {
        $tempPath = $pathFoto;
        $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
        $pathNuevo = $obj->nombre . "." . $obj->tipo . "." . $accion . "." . date("Gis") . "." . $extension;

        //si la foto no existia desde un principio no hago nada, si existe la muevo
        if($accion === 'borrado')
        {
            if (file_exists("./recetas/imagenes/" . $tempPath)) {
            rename(chop("./recetas/imagenes/" . $tempPath), chop("./recetasBorradas/" . $pathNuevo));
            }
        }
        else
        {
            if (file_exists("./recetas/imagenes/" . $tempPath)) {
            rename(chop("./recetas/imagenes/" . $tempPath), chop("./recetasModificadas/" . $pathNuevo));
            }
        }
            
            $obj->pathFoto = $pathNuevo; 
    }
    }

<?php
    require_once 'I2.php';
    require_once 'Iparte3.php';
    require_once 'accesodatos.php';
    
    class Ovni implements Iparte2Ovni{
        public $tipo;
        public $velocidad;
        public $planetaOrigen;
        public $pathFoto;

        public function __construct($tipo = 'tipo 1', $velocidad = 100, $planetaOrigen = 'marte', $pathFoto = null)
        {
            $this->tipo = $tipo;
            $this->velocidad = $velocidad;
            $this->planetaOrigen = $planetaOrigen;
            $this->pathFoto = $pathFoto;
        }

        public function ToJson()
        {
            //aca si puedo hacer esto porque son todos los atributos publicos
            return json_encode($this);
        }

        public function Agregar()
        {
            $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO ovnis (tipo, velocidad, planeta, foto) VALUES (:tipo, :velocidad, :planeta, :foto)");

                $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
                $consulta->bindValue(":velocidad", $this->velocidad, PDO::PARAM_INT);
                $consulta->bindValue(":planeta", $this->planetaOrigen, PDO::PARAM_STR);
                $consulta->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);

                $consulta->execute();

                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
        }

        public static function Traer()
        {
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("SELECT * FROM `ovnis`");
                $consulta->execute();
    
                while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $user_array[] = new Ovni($row['tipo'], $row['velocidad'], $row['planeta'], $row['foto']);
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

        public static function TraerId($id)
        {
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("SELECT * FROM `ovnis` WHERE id = :id");

                $consulta->bindValue(":id", $id, PDO::PARAM_INT);

                $consulta->execute();
    
                while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $user_array[] = new Ovni($row['tipo'], $row['velocidad'], $row['planeta'], $row['foto']);
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

        public function ActivarVelocidadWarp()
        {
            return $this->velocidad * 10.45;
        }

        public function Existe($ovnis_array)
        {
            $ret = false;

            foreach($ovnis_array as $ovni)
            {
                if($this->tipo == $ovni->tipo && $this->planetaOrigen == $ovni->planetaOrigen)
                {
                    $ret = true;
                    break;
                }
            }

            return $ret;
        }

        //Devuelve el nombre que se le puso a la foto, o null si no existe la foto o algo
        public static function GenerarNombreFoto($foto, $tipo, $planetaOrigen)
        {
            $ret = null;
            if($foto != null){

                $tempPath = $foto["name"];
                $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
                $foto["name"] = $tipo . "." . $planetaOrigen . "." . date("Gis") . "." . $extension;
                $ret = $foto["name"];

            }
            return $ret;
        }

        public function Modificar($id)
        {
            $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("UPDATE ovnis SET tipo = :tipo, velocidad = :velocidad, planeta = :planetaOrigen, foto = :foto WHERE id = :id");

                $consulta->bindValue(":id", $id, PDO::PARAM_INT);
                $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
                $consulta->bindValue(":velocidad", $this->velocidad, PDO::PARAM_STR);
                $consulta->bindValue(":planetaOrigen", $this->planetaOrigen, PDO::PARAM_INT);
                $consulta->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);

                $consulta->execute();

                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
        }

        //De instancia
        // public function Eliminar()
        // {
        //     $ret = false;
        //     try {
        //         $AccesoDatos = AccesoDatos::TraerAccesoDatos();
        //         $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM ovnis WHERE tipo = :tipo AND planeta = :planetaOrigen");

        //         $consulta->bindValue(":tipo", $this->tipo, PDO::PARAM_STR);
        //         $consulta->bindValue(":planetaOrigen", $this->planetaOrigen, PDO::PARAM_INT);

        //         $consulta->execute();

        //         $ret = true;
        //     } catch (Exception $e) {
        //         echo $e->getMessage();
        //         return false;
        //     }
        //     return $ret;
        // }

        //De clase 
        public static function Eliminar($id)
        {
            $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                 $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM ovnis WHERE id = :id");

                $consulta->bindValue(":id", $id, PDO::PARAM_INT);

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
            $nombreArchivo = "./archivos/OvnisBorrados.txt";
            $archivo = fopen($nombreArchivo, "a+");

            $pathFoto = $this->pathFoto;

            //Si tiene path foto la muevo
            if($pathFoto != null)
            {
                Ovni::MoverFoto($pathFoto, $this, 'borrado');
            }
            
            //Lo escribo en formato json
            fwrite($archivo, $this->ToJson() . "\r\n");

            fclose($archivo);
        }

        public static function MoverFoto($pathFoto, $obj, $accion)
        {
            $tempPath = $pathFoto;
            $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
            $pathNuevo = $obj->tipo . "." . $accion . "." . date("Gis") . "." . $extension;

            //si la foto no existia desde un principio no hago nada, si existe la muevo
            if($accion === 'borrado')
            {
                if (file_exists("./ovnis/imagenes/" . $tempPath)) {
                rename(chop("./ovnis/imagenes/" . $tempPath), chop("./ovnisBorrados/" . $pathNuevo));
                }
            }
            else
            {
                if (file_exists("./ovnis/imagenes/" . $tempPath)) {
                    rename(chop("./ovnis/imagenes/" . $tempPath), chop("./ovnisModificados/" . $pathNuevo));
                    }
            }
            
            $obj->pathFoto = $pathNuevo; 
        }

        public static function MostrarBorrados()
        {
            $ret = array();
            $f = fopen("./archivos/OvnisBorrados.txt", "r");

            while (!feof($f)) {
                $line = trim(fgets($f));
                $ovni = json_decode($line);
                if ($line != null)
                    array_push($ret, new Ovni($ovni->tipo, $ovni->velocidad, $ovni->planetaOrigen, $ovni->pathFoto));
            }
            fclose($f);
            
            return $ret;
        }
    }
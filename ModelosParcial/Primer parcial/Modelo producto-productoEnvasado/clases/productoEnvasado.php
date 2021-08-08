<?php

require_once 'producto.php';
require_once 'accesodatos.php';

class ProductoEnvasado extends Producto
{
    public $id;
    public $codigoBarra;
    public $precio;
    public $pathFoto;

    public function __construct($id = null, $nombre = null, $origen = null, $codigoBarra = null, $precio = null, $pathFoto = null)
    {
        parent::__construct($nombre, $origen);
        $this->id = $id;
        $this->codigoBarra = $codigoBarra;
        $this->precio = $precio;
        $this->pathFoto = $pathFoto;
    }

    public function ToJson()
    {
        //puedo porque son publicos, si no tendria que hacerlo a mano
        return json_encode($this);
    }

    public function Agregar()
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO productos (nombre, origen, codigo_barra, precio, foto) VALUES (:nombre, :origen, :codigoBarra, :precio, :foto)");

            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(":codigoBarra", $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    //devuelve el array de prodcutos o false si falla o la bd esta vacia
    public static function Traer()
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT * FROM `productos`");
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $user_array[] = new ProductoEnvasado($row['id'], $row['nombre'], $row['origen'], $row['codigo_barra'], $row['precio'], $row['foto']);
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

    public static function Eliminar($id)
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
             $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM productos WHERE id = :id");

            $consulta->bindValue(":id", $id, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    public function Modificar()
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, codigo_barra = :codigoBarra, precio = :precio, foto = :foto WHERE id = :id");

            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(":codigoBarra", $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    public function Existe($prodArray)
    {
        $ret = false;
        foreach($prodArray as $producto){
            if($producto->nombre == $this->nombre && $producto->origen == $this->origen)
            {
                $ret = true;
                break;
            }
        }
        return $ret;
    }

    public function ExisteId($prodArray)
    {
        $ret = false;
        foreach($prodArray as $producto){
            if($producto->id == $this->id)
            {
                $ret = true;
                break;
            }
        }
        return $ret;
    }

    public function GuardarEnArchivo()
    {
        $nombreArchivo = "./archivos/productosEnvasadosBorrados.txt";
        $archivo = fopen($nombreArchivo, "a+");

        $pathFoto = $this->pathFoto;

        //Si tiene path foto la muevo
        if($pathFoto != null)
        {
            ProductoEnvasado::MoverFoto($pathFoto, $this, 'borrado');
        }
            
        //Lo escribo en formato json
        fwrite($archivo, $this->ToJson() . "\r\n");

        fclose($archivo);
    }

    public static function MoverFoto($pathFoto, $obj, $accion)
    {
        $tempPath = $pathFoto;
        $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
        $pathNuevo = $obj->id . "." . $obj->nombre . "." . $accion . "." . date("Gis") . "." . $extension;

        //si la foto no existia desde un principio no hago nada, si existe la muevo
        if($accion === 'borrado')
        {
            if (file_exists("./productos/imagenes/" . $tempPath)) {
            rename(chop("./productos/imagenes/" . $tempPath), chop("./productosBorrados/" . $pathNuevo));
            }
        }
        else
        {
            if (file_exists("./productos/imagenes/" . $tempPath)) {
            rename(chop("./productos/imagenes/" . $tempPath), chop("./productosModificados/" . $pathNuevo));
            }
        }
            
            $obj->pathFoto = $pathNuevo; 
    }

    //Devuelve el nombre que se le puso a la foto, o null si no existe la foto o algo
    public static function GenerarNombreFoto($foto, $nombre, $origen)
    {
        $ret = null;
        if($foto != null){
        
            $tempPath = $foto["name"];
            $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
            $foto["name"] = $nombre . "." . $origen . "." . date("Gis") . "." . $extension;
            $ret = $foto["name"];
        
        }
        return $ret;
    }

    public static function MostrarBorrados()
    {
        $ret = array();
        $f = fopen("./archivos/productosEnvasadosBorrados.txt", "r");

        while (!feof($f)) {
            $line = trim(fgets($f));
            $prod = json_decode($line);
            if ($line != null)
                array_push($ret, new ProductoEnvasado($prod->id, $prod->nombre, $prod->origen, $prod->codigoBarra, $prod->precio, $prod->pathFoto));
        }
        fclose($f);
        
        return $ret;
    }
}
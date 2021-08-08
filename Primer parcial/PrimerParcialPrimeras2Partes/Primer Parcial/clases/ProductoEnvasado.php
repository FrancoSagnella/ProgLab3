<?php

    require_once "Producto.php";
    require_once "Iparte1.php";
    require_once "Iparte2.php";
    require_once "AccesoDatos.php";

    class ProductoEnvasado extends Producto implements Iparte1, Iparte2
    {
        public $id;
        public $codigoBarra;
        public $precio;
        public $pathFoto;

        public function __construct($id, $nombre, $origen, $codigoBarra, $precio, $pathFoto)
        {
            parent::__construct($nombre, $origen);
            $this->id = $id;
            $this->codigoBarra = $codigoBarra;
            $this->precio = $precio;
            $this->pathFoto = $pathFoto;
        }

        public function ToJSON()
        {
            return json_encode($this);
        }

        public function Agregar()
        {
            $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO productos (codigo_barra, nombre, origen, precio, foto) VALUES (:codigo_barra, :nombre, :origen, :precio, :foto)");

                $consulta->bindValue(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
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

        public static function Traer()
        {
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("SELECT * FROM productos");
                $consulta->execute();
    
                while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $empl_array[] = new ProductoEnvasado($row['id'], $row['nombre'], $row['origen'], $row['codigo_barra'], $row['precio'], $row['foto']);
                }
    
                if (isset($empl_array)) {
                    return $empl_array;
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
            try{
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM productos WHERE id = :id");
    
                $consulta->bindValue(":id", $id, PDO::PARAM_INT);
    
                $consulta->execute();
    
                $ret = true;
            }catch(Exception $e){
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
                $consulta = $AccesoDatos->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, codigo_barra = :codigo_barra, precio = :precio, foto = :foto WHERE id = :id");

                $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(":origen", $this->origen, PDO::PARAM_STR);
                $consulta->bindValue(":codigo_barra", $this->codigoBarra, PDO::PARAM_INT);
                $consulta->bindValue(":foto", $this->pathFoto, PDO::PARAM_STR);
                $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);

                $consulta->execute();

                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
        }
    }
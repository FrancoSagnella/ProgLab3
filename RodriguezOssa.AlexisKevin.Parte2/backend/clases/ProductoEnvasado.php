<?php
require_once "./clases/Producto.php";
require_once "./clases/IParte1.php";
require_once "./clases/IParte2.php";
require_once "./clases/AccesoDatos.php";

class ProductoEnvasado extends Producto implements IParte1,IParte2
{
    public $id;
    public $codigoBarra;
    public $precio;
    public $pathFoto;

    public function __construct($nombre,$origen,$id,$codigoBarra,$pathFoto,$precio)
    {
        parent::__construct($nombre,$origen);
        $this->id=$id;
        $this->codigoBarra=$codigoBarra;
        $this->pathFoto=$pathFoto;
        $this->precio=$precio;
    }
    public function ToJSON()
    {
        return json_encode($this);

    }
    public function Agregar()
    {
        $validar=true;
        try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO productos (codigo_barra, nombre, origen, precio, foto)"
                                                    . "VALUES(:codigo_barra, :nombre, :origen, :precio, :foto)");
        
        $consulta->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':origen', $this->origen, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);

        $consulta->execute();   
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $validar=false;
        }
    return $validar;
    }
    public static function Traer()
    {
        try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `productos`");        
            
            $consulta->execute();
            
            while($row=$consulta->fetch(PDO::FETCH_ASSOC))
            {
                 $productoEnvasado[]= new ProductoEnvasado($row['nombre'],$row['origen'],$row['id'],$row['codigo_barra'],$row['foto'],$row['precio']);
            }
    
           
            }
            catch(Exception $e){
                echo $e->getMessage();
    
            }
            
    
            return $productoEnvasado; 
    }
    public function Modificar()
    {
        $validar=false;
        try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE productos SET codigo_barra=:codigo_barra,nombre=:nombre
                                                    ,origen=:origen,precio=:precio,foto=:foto WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':origen', $this->origen, PDO::PARAM_STR);
        $consulta->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);

        $consulta->execute();   
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $validar=false;
        }
        if($consulta->rowCount() > 0) 
        {
            $validar = true;
        }
       
    return $validar;
    }
    public static function Eliminar($id)
    {
        $validar=false;
        try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM productos WHERE id=:id");
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);        

        $consulta->execute();   
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            $validar=false;
        }
        if($consulta->rowCount() > 0) 
        {
            $validar = true;
        }
       
    return $validar;
    }
}
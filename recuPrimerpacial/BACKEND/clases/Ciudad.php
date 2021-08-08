<?php

use Ciudad as GlobalCiudad;

include_once "AccesoDatos.php";

class Ciudad
{
    public $id;
    public $nombre;
    public $poblacion;
    public $pais;
    public $pathFoto;

public function __construct($id=null,$nombre=null,$poblacion=null,$pais=null,$pathFoto=null)
{
    $this->id=$id;
    $this->nombre=$nombre;
    $this->pais=$pais;
    $this->poblacion=$poblacion;
    $this->pathFoto=$pathFoto;
}
public function ToJSON()
{
    return json_encode($this) ;
}
public function Agregar()
{
    $validar=true;
    try{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO ciudades ( nombre, poblacion, pais, path_foto)"
                                                . "VALUES(:nombre, :poblacion, :pais, :pathFoto)");
    
    //$consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
    $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
    $consulta->bindValue(':poblacion', $this->poblacion, PDO::PARAM_INT);
    $consulta->bindValue(':pais', $this->pais, PDO::PARAM_STR);
    $consulta->bindValue(':pathFoto', $this->pathFoto, PDO::PARAM_STR);

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
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT id, nombre, poblacion, pais, path_foto as pathFoto from ciudades");
		$consulta->execute();			
		while($row=$consulta->fetch(PDO::FETCH_ASSOC))
            {
                 $ciudades[]= new GlobalCiudad($row['id'],$row['nombre'],$row['poblacion'],$row['pais'],$row['pathFoto']);
            }
             
           
            }
            catch(Exception $e){
                echo $e->getMessage();
    
            }
            
    
            return $ciudades; 	
	}

    public function Existe($array)
    {
        $retornor=false;
       // $lista = ProductoEnvasado::Traer();
        foreach($array as $ciudad)
        {
            if($ciudad->pais==$this->pais && $ciudad->nombre==$this->nombre)
            {
                $retornor=true;
            }
        }
        return $retornor;
    }
    public function Eliminar()
    {
        $validar=false;
        try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM ciudades WHERE nombre=:nombre and pais=:pais");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':pais', $this->pais, PDO::PARAM_STR);       

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

    public function Modificar()
    {
        $validar=false;
        try{
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE ciudades SET nombre=:nombre,poblacion=:poblacion
                                                    ,pais=:pais,path_foto=:foto WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':pais', $this->pais, PDO::PARAM_STR);
        $consulta->bindValue(':poblacion', $this->poblacion, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

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

    public   function GuardarEnArchivo($string)
    {
       /* $pathFoto = $this->pathFoto;
             $pahtViejoAgregado="productos/imagenes/" . $pathFoto;

        $tipoDeFoto =pathinfo($pahtViejoAgregado, PATHINFO_EXTENSION);*/
        if($string=="borrar")
        {
            $fp = fopen("./archivos/ciudades_borradas.json","a");
            
            $validarJSon=json_decode('{"exito":"false", "mensaje":"no se logro guardar correctamente"}');
            $ciudad=$this->ToJSON();
            $guardar=trim($ciudad);
            if(fwrite($fp,$guardar . "\r\n")>0)
            {
                $validarJSon->exito="true";
                $validarJSon->mensaje="guardado correctamente";
            }
            fclose($fp);
               
            return $validarJSon;
        }
        else if($string=="modificar")
        {
            $fp = fopen("./archivos/ciudades_modificadas.json","a");
            
            $validarJSon=json_decode('{"exito":"false", "mensaje":"no se logro guardar correctamente"}');
            $ciudad=$this->ToJSON();
            $guardar=trim($ciudad);
            if(fwrite($fp,$guardar . "\r\n")>0)
            {
                $validarJSon->exito="true";
                $validarJSon->mensaje="guardado correctamente";
            }
            fclose($fp);
               
            return $validarJSon;
        }
    
        
    }
}
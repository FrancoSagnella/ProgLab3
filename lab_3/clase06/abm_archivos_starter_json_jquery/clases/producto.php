<?php
class Producto
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	private $codBarra;
 	private $nombre;
  	private $pathFoto;
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
	public function GetCodBarra()
	{
		return $this->codBarra;
	}
	public function GetNombre()
	{
		return $this->nombre;
	}
	public function GetPathFoto()
	{
		return $this->pathFoto;
	}

	public function SetCodBarra($valor)
	{
		$this->codBarra = $valor;
	}
	public function SetNombre($valor)
	{
		$this->nombre = $valor;
	}
	public function SetPathFoto($valor)
	{
		$this->pathFoto = $valor;
	}

//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($codBarra=NULL, $nombre=NULL, $pathFoto=NULL)
	{
		if($codBarra !== NULL && $nombre !== NULL){
			$this->codBarra = $codBarra;
			$this->nombre = $nombre;
			$this->pathFoto = $pathFoto;
		}
	}

//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->codBarra." - ".$this->nombre." - ".$this->pathFoto."\r\n";
	}
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODOS DE CLASE
	public static function Guardar($obj)
	{
		$resultado = FALSE;
		
		//ABRO EL ARCHIVO
		$ar = fopen("archivos/productos.txt", "a");
		
		//ESCRIBO EN EL ARCHIVO
		$cant = fwrite($ar, $obj->ToString());
		
		if($cant > 0)
		{
			$resultado = TRUE;			
		}
		//CIERRO EL ARCHIVO
		fclose($ar);
		
		return $resultado;
	}
	public static function SobreescribirLista($objArray)
	{
		$resultado = FALSE;
		
		//ABRO EL ARCHIVO
		$ar = fopen("archivos/productos.txt", "w");
		
		//ESCRIBO EN EL ARCHIVO
		if(count($objArray) !== 0)
		{
			foreach($objArray as $obj)
			{
				$cant = fwrite($ar, $obj->ToString());
			}
		
			if($cant > 0)
			{
				$resultado = TRUE;			
			}
		}
		else
		{
			fwrite($ar, "");
			$resultado = TRUE;	
		}
		
		//CIERRO EL ARCHIVO
		fclose($ar);
		
		return $resultado;
	}
	public static function TraerTodosLosProductos()
	{

		$ListaDeProductosLeidos = array();

		//leo todos los productos del archivo
		$archivo=fopen("archivos/productos.txt", "r");
		
		while(!feof($archivo))
		{
			$archAux = trim(fgets($archivo));
			$productos = explode(" - ", $archAux);
			//http://www.w3schools.com/php/func_string_explode.asp
			$productos[0] = trim($productos[0]);
			if($productos[0] != ""){
				$ListaDeProductosLeidos[] = new Producto($productos[0], $productos[1],$productos[2]);
			}
		}
		fclose($archivo);
		
		return $ListaDeProductosLeidos;
		
	}
	public static function Modificar($obj)
	{
		$resultado = false;
		
		if(Producto::Eliminar($obj->codBarra))
		{
			if(Producto::Guardar($obj))
				$resultado = true;
		}
		
		return $resultado;
	}
	public static function Eliminar($codBarra)
	{
		$resultado = false;
		
		$prodArray = Producto::TraerTodosLosProductos();
		$keyAux = false;
		foreach($prodArray as $key => $prodcuto)
		{
			if($prodcuto->GetCodBarra() == $codBarra)
			{
				Archivo::Borrar("./archivos/" . $prodcuto->GetPathFoto());
				$keyAux = $key;
				break;
			}
		}

		if($keyAux !== false)
		{
			unset($prodArray[$keyAux]);
			if(Producto::SobreescribirLista($prodArray))
			{	
				$resultado = true;
			}
		}
		
		return $resultado;
	}
//--------------------------------------------------------------------------------//
}
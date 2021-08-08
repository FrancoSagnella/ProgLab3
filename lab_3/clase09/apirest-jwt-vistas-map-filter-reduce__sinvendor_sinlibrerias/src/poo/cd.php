<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once __DIR__ . "/icrud.php";

class Cd implements ICRUD {

    function TraerTodos(Request $request, Response $response, array $args) : Response {

        $todosLosCds = CD::TraerTodoLosCds();

        $newResponse = $response->withStatus(200);

        $newResponse->getBody()->write(json_encode($todosLosCds));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    function TraerUno(Request $request, Response $response, array $args) : Response {

        $id = $args['id'];
    	$elCd = CD::TraerUnCd($id);

        $newResponse = $response->withStatus(200);

        $newResponse->getBody()->write(json_encode($elCd));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    function Agregar(Request $request, Response $response, array $args) : Response {

        $ArrayDeParametros = $request->getParsedBody();

		$titulo = $ArrayDeParametros['titulo'];
        $cantante = $ArrayDeParametros['cantante'];
        $año = $ArrayDeParametros['anio'];
        
        $micd = new CD();
        $micd->titulo = $titulo;
        $micd->cantante = $cantante;
		$micd->año = $año;		

        $id_agregado = $micd->InsertarCd();
		
        $datos = new stdClass();
  
		if($id_agregado > 0)
		{
			$datos->mensaje = "CD agregado!!!";
			$datos->id_agregado = $id_agregado;
		}
		else
		{
			$datos->mensaje = "CD NO agregado!!!";
		}

        $newResponse = $response->withStatus(200);

        $newResponse->getBody()->write(json_encode($datos));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    function Modificar(Request $request, Response $response, array $args) : Response {   

		$obj = json_decode($_POST["cadenaJson"]);

	    $micd = new CD();
	    $micd->id = $obj->id;
	    $micd->titulo = $obj->titulo;
	    $micd->cantante = $obj->cantante;
	    $micd->año = $obj->anio;

		$resultado = $micd->ModificarCd();
		   
	   	$objDelaRespuesta = new stdclass();
		$objDelaRespuesta->resultado = $resultado;

        $newResponse = $response->withStatus(200);

        $newResponse->getBody()->write(json_encode($objDelaRespuesta));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    function Eliminar(Request $request, Response $response, array $args) : Response {

        $obj = json_decode($_POST["cadenaJson"]);
        
        $cd = new CD();
        $cd->id = $obj->id;
            
        $cantidadDeBorrados = $cd->BorrarCd();

        $objDelaRespuesta = new stdclass();
        $objDelaRespuesta->cantidad = $cantidadDeBorrados;
        
        if($cantidadDeBorrados>0)
        {
            $objDelaRespuesta->resultado = "algo borró!!!";
        }
        else
        {
            $objDelaRespuesta->resultado = "no borró nada!!!";
        }

        $newResponse = $response->withStatus(200);

        $newResponse->getBody()->write(json_encode($objDelaRespuesta));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }


    private static function TraerTodoLosCds()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, titel as titulo, interpret as cantante, jahr as año 
                                                        from cdcol.cds");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "CD");		
	}

	private static function TraerUnCd($id) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, titel as titulo, interpret as cantante, jahr as año 
                                                        from cdcol.cds where id = $id");
		$consulta->execute();
		$cdBuscado = $consulta->fetchObject('cd');
		return $cdBuscado;		
	}

	private function InsertarCd()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("INSERT into cdcol.cds (titel,interpret,jahr)
                                                        values(:titulo,:cantante,:anio)");
		$consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_INT);
		$consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
		$consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);
		$consulta->execute();	

		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

	private function ModificarCd()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("
				update cdcol.cds 
				set titel=:titulo,
				interpret=:cantante,
				jahr=:anio
				WHERE id=:id");
		$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
		$consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_INT);
		$consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
		$consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);

		return $consulta->execute();
	 }

	private function BorrarCd()
	{
	 	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("delete from cdcol.cds WHERE id=:id");	
		$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
	}

}
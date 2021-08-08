<?php

//puedo usar los tipos response y request y routeCollectorProxy (para armar los grupos)

use Cd as GlobalCd;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//Puedo usar la clase responseMW (los objetos response que provienen delos middlewares)
use Slim\Psr7\Response as ResponseMW;

//En esta clase me van a quedar los metodos para conectarme con la base de datos de cd (traer, agregar, etc)
//Me queda el ABM y los metodos de la API que me dejan hacer ese ABM
class Cd{

    public $id;
    public $titulo;
    public $cantante;
    public $año;

    public static function construirCD($id, $titulo, $cantante, $año)
    {   
        $cd = new Cd();
        $cd->id = $id;
        $cd->titulo = $titulo;
        $cd->cantante  = $cantante;
        $cd->año = $año;

        return $cd;
    }

    public function TraerTodos(Request $request, Response $response, array $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo traer el listado';
        $retorno->listado = '';
        $retorno->status = 400;

        if(($cdLista = Cd::TraerTodoLosCds()) !== false)
        {
            $retorno->listado = $cdLista;
            $retorno->exito = true;
            $retorno->mensaje = 'Listado recuperado';
            $retorno->status = 200;
        }

        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno(Request $request, Response $response, array $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo traer el cd solicitado';
        $retorno->cd = '';
        $retorno->status = 400;

        if(($cd = Cd::TraerUnCd($args['id'])) !== false)
        {
            $retorno->cd = $cd;
            $retorno->exito = true;
            $retorno->mensaje = 'Cd recuperado';
            $retorno->status = 200;
        }

        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function Agregar(Request $request, Response $response, array $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo agregar el cd';
        $retorno->id_agregado = null;
        $retorno->status = 400;

        $params = $request->getParsedBody();
        $cd_json = json_decode($params['json_cd']);
        $cd = Cd::construirCD(null, $cd_json->titulo, $cd_json->cantante, $cd_json->año);

        if(($cdId = $cd->InsertarCd()) !== false)
        {   
            $retorno->exito = true;
            $retorno->mensaje = 'Cd agregado con exito';
            $retorno->id_agregado = $cdId;
            $retorno->status = 200;
        }
        
        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');

    }

    public function Modificar(Request $request, Response $response, array $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo modificar el cd';
        $retorno->status = 400;

        $params = json_decode($request->getBody()->getContents());
        $cd = Cd::construirCD($params->id, $params->titulo, $params->cantante, $params->año);

        if(($cd->ModificarCd()))
        {
            $retorno->exito = true;
            $retorno->mensaje = 'Cd modificado';
            $retorno->status = 200;
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }

    public function Eliminar(Request $request, Response $response, array $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo eliminar el cd';
        $retorno->status = 400;

        $params = json_decode($request->getBody()->getContents());
        $cd = Cd::construirCD($params->id, null,null,null);

        //devuelve el numero de filas, si devuelve 0 no entra
        if(($cd->BorrarCd()))
        {
            $retorno->exito = true;
            $retorno->mensaje = 'Cd borrado';
            $retorno->status = 200;
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }

    public static function TraerTodoLosCds()
	{
        try
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("select id, titel as titulo, interpret as cantante, jahr as año from cds");
		    $consulta->execute();	

		    $ret =  $consulta->fetchAll(PDO::FETCH_CLASS, "Cd");
            
            if(isset($ret))
            {
                return $ret;
            }
            else{
                return false;
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
			
	}

	public static function TraerUnCd($id) 
	{
        try{

		    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("select id, titel as titulo, interpret as cantante, jahr as año from cds where id = $id");
		    $consulta->execute();
		    $cdBuscado = $consulta->fetchObject('cd');
		    
            if(isset($cdBuscado))
            {
                return $cdBuscado;
            }
            else{
                return false;
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
	}

	public function InsertarCd()
	{
        try{

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into cds (titel,interpret,jahr)values(:titulo,:cantante,:anio)");
		    $consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_STR);
		    $consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
		    $consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);
		    $consulta->execute();	

		    return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }
        catch (Exception $e){
            echo $e->getMessage();
            return false;
        }
		
	}

	public function ModificarCd()
	{
        try{
		    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE cds SET titel=:titulo, interpret=:cantante, jahr=:anio WHERE id=:id");

		    $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
		    $consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_STR);
		    $consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
		    $consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);

            //devuelve true si se ejectuo bien, false si no
		    return $consulta->execute();
        }
        catch (Exception $e){
            echo $e->getMessage();
            return false;
        }

	 }

	public function BorrarCd()
	{
        try{
	 	    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM cds	WHERE id=:id");	
		    $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
		    $consulta->execute();

            //devuelve el numero de filas borradas
		    return $consulta->rowCount();
        }
        catch (Exception $e){
            echo $e->getMessage();
            return false;
        }
	}
}
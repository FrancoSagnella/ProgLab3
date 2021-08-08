<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once __DIR__ . "/ivalidable.php";
require_once __DIR__ . "/usuario.php";
require_once __DIR__ . "/accesoDatos.php";
require_once __DIR__ . "/autentificadora.php";


class Verificadora implements IValidable{

    public function VerificarUsuario(Request $request, Response $response, array $args) : Response {
    
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    private static function ExisteUsuario($objUser)
    {
        $existe = FALSE;
        
        return $existe;
    }

    public function ObtenerDataJWT(Request $request, Response $response, array $args) : Response
    {
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
  
    public function ChequearJWT(Request $request, RequestHandler $handler) : ResponseMW
    {
        return $response->withHeader('Content-Type', 'application/json');
    }

    //IValidable
    public function ValidarParametrosUsuario(Request $request, RequestHandler $handler) : ResponseMW {
          
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    } 

    public function ValidarParametrosCDAgregar(Request $request, RequestHandler $handler) : ResponseMW {
 
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    } 

    public function ValidarParametrosCDModificar(Request $request, RequestHandler $handler) : ResponseMW {

        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    } 

    public function ValidarParametrosCDBorrar(Request $request, RequestHandler $handler) : ResponseMW {
    
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    } 
}
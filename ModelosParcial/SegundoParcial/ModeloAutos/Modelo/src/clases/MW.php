<?php

//puedo usar los tipos response y request y routeCollectorProxy (para armar los grupos)
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

//Puedo usar la clase responseMW (los objetos response que provienen delos middlewares)
use Slim\Psr7\Response as ResponseMW;

require_once 'auto.php';
require_once 'usuario.php';

class MW{
    public function VerificarTokenMW(Request $request, RequestHandler $handler) : ResponseMW
    {
        $retorno = new stdClass();

        $token = $request->getHeader('token')[0];

        $retorno = AutentificadoraJWT::ValidarJWT($token);
        if($retorno->exito)
        {
            $retorno = json_decode(($handler->handle($request))->getBody());
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }


    public static function VerificarPropietario(Request $request, RequestHandler $handler) : ResponseMW
    {
        $retorno = new stdClass();

        $token = $request->getHeader('token')[0];
        $retorno  = AutentificadoraJWT::ObtenerPayLoad($token);

        if($retorno->exito && $retorno->payload->perfil === 'propietario')
        {
            $retorno = json_decode(($handler->handle($request))->getBody());
        }
        else{
            $retorno->mensaje = 'Error, el usuario es '. $retorno->payload->perfil;
            $retorno->status = 409;
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }


    public function VerificarEncargado(Request $request, RequestHandler $handler) : ResponseMW
    {
        $retorno = new stdClass();

        $token = $request->getHeader('token')[0];
        $retorno  = AutentificadoraJWT::ObtenerPayLoad($token);
        
        if($retorno->exito && ($retorno->payload->perfil === 'encargado' || $retorno->payload->perfil === 'propietario'))
        {
            $retorno = json_decode(($handler->handle($request))->getBody());
        }
        else{
            $retorno->mensaje = 'Error, el usuario es '. $retorno->payload->perfil;
            $retorno->status = 409;
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }
}
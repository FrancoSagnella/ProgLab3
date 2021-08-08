<?php

//puedo usar los tipos response y request y routeCollectorProxy (para armar los grupos)
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

//Puedo usar la clase responseMW (los objetos response que provienen delos middlewares)
use Slim\Psr7\Response as ResponseMW;

require_once 'usuario.php';
require_once 'autentificadora.php';

//En esta clase me quedaron los metodos para vrear y verificar los JWT y los metodos MiddleWares
class Verificadora{
    public function VerificarUsuario(Request $request, Response $response, array $args)
    {
        $retorno = new stdClass();
        $retorno->jwt = null;
        $retorno->status = 403;

        $params = $request->getParsedBody();
        $json_usuario = json_decode($params['obj_json']);
        $correo = $json_usuario->correo;
        $clave = $json_usuario->clave;

        $usuario = Usuario::TraerUnUsuario($correo, $clave);
        if($usuario != false)
        {
            //cambio el status a retornar como deba
            $retorno->status = 200;
            //escribo en el retorno el json web token
            $retorno->jwt = Autentificadora::CrearJWT($usuario);
        }

        //retorno la respuesta con formato json
        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ValidarParametrosUsuario(Request $request, RequestHandler $handler) : ResponseMW
    {
        $params = $request->getParsedBody();

        $retorno = new stdClass();
        $retorno->mensaje = "No se paasron correctamente los parametros";
        $retorno->status = 403;

        if(isset($params['obj_json']))
        {
            $json = json_decode($params['obj_json']);

            if(isset($json->correo) && isset($json->clave))
            {
                $retorno = json_decode(($handler->handle($request))->getBody());
            }
        }
        
        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }

    public function ObtenerDataJWT(Request $request, Response $response, array $args)
    {
        //el token me viene desde el header de l;a pticion, no por el body por eso lo recupero asi
        $token = $request->getHeader('token')[0];
        //lo que me devuelve esa funcion es el json con el retorno
        $retorno = Autentificadora::ObtenerPayLoad($token);

        //dependiendo si funco o no le pongo el status
        if($retorno->exito)
        {
            $retorno->status = 200;
        }
        else{
            $retorno->status = 403;
        }

        //creo la nueva respuesta, a partir del parametro response con su respectivo status y en json de retorno escrito
        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ChequearJWT(Request $request, RequestHandler $handler) : ResponseMW
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "no se envio token";
        $retorno->status = 403;

        $array = $request->getHeader('token');
        if(isset($array[0]))
        {
            $token = $array[0];
            $retorno = Autentificadora::ValidarJWT($token);

            if($retorno->exito)
            {
                $retorno = json_decode(($handler->handle($request))->getBody());
            }
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ValidarParametrosCdAgregar(Request $request, RequestHandler $handler) : ResponseMW
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Alguno de los parametros nofue enviado";
        $retorno->status = 403;

        $params = $request->getParsedBody();

        if(isset($params['json_cd']))
        {
            $cd_json = json_decode($params['json_cd']);

            if(isset($cd_json->titulo) && isset($cd_json->cantante) && isset($cd_json->año))
            {
                //el retorno va a tomar el valor de lo que devuelve el proximo calleable
                $retorno = json_decode(($handler->handle($request))->getBody());
            }
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ValidarParametrosCdModificar(Request $request, RequestHandler $handler) : ResponseMW
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "El parametro obj no fue enviado";
        $retorno->status = 500;

        $params = json_decode($request->getBody()->getContents());

        if(isset($params))
        {
            $retorno->mensaje = "Alguno de los atributos no fue enviado";

            if(isset($params->id) && isset($params->titulo) && isset($params->cantante) && isset($params->año))
            {
                //el retorno va a tomar el valor de lo que devuelve el proximo calleable (haya funcionado o no)
                $retorno = json_decode(($handler->handle($request))->getBody());
            }
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function ValidarParametrosCdEliminar(Request $request, RequestHandler $handler) : ResponseMW
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "El parametro obj no fue enviado";
        $retorno->status = 403;

        $params = json_decode($request->getBody()->getContents());

        if(isset($params))
        {
            $retorno->mensaje = "El atributo id no fue enviado";
            if(isset($params->id))
            {
                //el retorno va a tomar el valor de lo que devuelve el proximo calleable (haya funcado o no)
                $retorno = json_decode(($handler->handle($request))->getBody());
            }
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
}
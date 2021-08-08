<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

require_once 'accesodatos.php';
require_once 'usuario.php';

class Verificadora {
    public function VerificarUsuario(Request $request, RequestHandler $handler) : ResponseMW{

        
        $retorno = new stdClass();
        $retorno->mensaje = "Datos incorrectos ERROR";
        $status = 403;

        $arrayParams = $request->getParsedBody();
        $obj_json = json_decode($arrayParams["obj_json"]);

        if(Verificadora::ExisteUsuario($obj_json))
        {
            $APIresponse = $handler->handle($request);
            //lo que recibe APIresponse en el body es un string json
            //hago decode para guardar en $retorno el array de objetos stdClass
            $retorno = json_decode($APIresponse->getBody());
            $status = 200;
        }

        $newResponse = new ResponseMW($status);
        //cuando voy a escribir el $retorno en el nuevo response, hago un encode
        //porque lo que en retorno tenia guardado era un array de objetos, y para el write le tengo que poner un string
        $newResponse->getBody()->write(json_encode($retorno));

        return $newResponse->withHeader('Content-type', 'application/json') ;
    }

    public static function ExisteUsuario($json)
    {
        $retorno = false;

        if(($user_array = Usuario::TraerTodosLosUsuarios()) != false)
        {
            foreach($user_array as $user)
            {
                if($user->correo === $json->correo && $user->clave === $json->clave)
                {
                     $retorno = true; 
                     break;
                }
            }
        }
        return $retorno;
    }

    public function VerificarParametro(Request $request, RequestHandler $handler) : ResponseMW{

        echo "entre al Mw<br>";
        $retorno = new stdClass();
        $retorno->mensaje = "No se recibio parametro ERROR";
        $status = 403;

        if($request->getMethod() === "GET")
        {
            $status = 200;
            $retorno = json_decode(($handler->handle($request))->getBody());
        }
        else if($request->getMethod() === "POST")
        {
            $params = $request->getParsedBody();
            if(isset($params["obj_json"]))
            {
                $json = json_decode($params["obj_json"]);
                $retorno->mensaje = "Le faltaban parametros al obj_json ERROR";

                if(isset($json->correo) && isset($json->clave))
                {
                    $status = 200;
                    //$APIresponse = (string) $handler->handle($request)->getBody(); si lo casteo a string me devuelve el json que le escribi antes, si no me devuelve un objeto re loco que por alguna rason, al hacerle el json decode despues igual se decodea bien el json que le cargue antes
                    //Si no lo casteo a string, tengo que hacerle un decode, y la cadena json que le guarde en mi api se transforma en el array de objetos de nuevo
                    $APIresponse = $handler->handle($request)->getBody();
                    $retorno = json_decode($APIresponse);
                }
            }
        } 

        $newResponse = new ResponseMW($status);
        $newResponse->getBody()->write(json_encode($retorno));

        return $newResponse->withHeader('Content-type', 'application/json');
    }
}
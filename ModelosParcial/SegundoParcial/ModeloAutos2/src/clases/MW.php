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

    //parte 2
    public function VerificarCamposSeteados(Request $request, RequestHandler $handler)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "No se enviaron los parametros";
        $retorno->status = 403;

        $params = $request->getParsedBody();
        if(isset($params['obj_json']))
        {
            $datos = json_decode($params['obj_json']);

            //si se envio solo correo
            if(isset($datos->correo) && !isset($datos->clave)){
                $retorno->mensaje = 'No se envio clave';
            }
            //si se envio solo clave
            else if(!isset($datos->correo) && isset($datos->clave)){
                $retorno->mensaje = 'No se envio correo';
            }
            //si no se envio ni correo ni clave
            else if(!isset($datos->correo) && !isset($datos->clave)){
                $retorno->mensaje = 'No se envio ni correo ni clave';
            }
            //si se enviaron los dos
            else{
                	$retorno = json_decode(($handler->handle($request))->getBody());
            }
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }



    public static function VerificarCamposVacios(Request $request, RequestHandler $handler)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Los campos estaban vacios";
        $retorno->status = 409;

        //Ya se que estan seteados
        $params = $request->getParsedBody();
        $datos = json_decode($params['obj_json']);

        if(strlen($datos->correo) === 0 && strlen($datos->clave) !== 0)
        {
            $retorno->mensaje = "El campo correo esta vacio";
        }
        else if(strlen($datos->correo) !== 0 && strlen($datos->clave) === 0)
        {
            $retorno->mensaje = "El campo clave esta vacio";
        }
        else if(strlen($datos->correo) === 0 && strlen($datos->clave) === 0)
        {
            $retorno->mensaje = "Tanto la clave como el correo estan vacios";
        }
        else
        {
            $retorno = json_decode(($handler->handle($request))->getBody());
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }




    public function VerificarCorreoClaveBD(Request $request, RequestHandler $handler)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "El correo no existe en la bd";
        $retorno->status = 403;

        $params = $request->getParsedBody();
        $datos = json_decode($params['obj_json']);

        if(($usuario = Usuario::TraerUnUsuario($datos->correo, $datos->clave)) !== false)
        {
            $retorno = json_decode(($handler->handle($request))->getBody());
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }




    public static function VerificarCorreoBD(Request $request, RequestHandler $handler)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "El correo ya existe en la bd";
        $retorno->status = 403;

        $params = $request->getParsedBody();
        $datos = json_decode($params['obj_json']);

        if(($usuario = Usuario::TraerUnUsuarioCorreo($datos->correo)) === false)
        {
            $retorno = json_decode(($handler->handle($request))->getBody());
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }




    public function VerificarParametrosAuto(Request $request, RequestHandler $handler)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "no se enviaron los parametros";
        $retorno->status = 409;

        $params = $request->getParsedBody();
        if(isset($params['obj_json']))
        {
            $datos = json_decode($params['obj_json']);

            $retorno->mensaje = "No se envio alguno de los campos";

            if(isset($datos->color) && isset($datos->marca) && isset($datos->modelo) && isset($datos->precio))
            {
                $retorno->mensaje = "";
                if(!($datos->precio >= 50000 && $datos->precio <= 600000))
                {
                    $retorno->mensaje .= "El precio no esta dentro del rango (50000/600000) ";
                }

                if($datos->color === 'azul')
                {
                    $retorno->mensaje .= "El color del auto no debe ser azul";
                }

                if(strlen($retorno->mensaje) === 0)
                {
                    $retorno = json_decode(($handler->handle($request))->getBody());
                }
            }
        }
        
        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }




    //parte 3
    public function VerificarTokenMW(Request $request, RequestHandler $handler)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "No se envio token";
        $retorno->status = 403;

        if(isset($request->getHeader('token')[0]))
        {
            $token = $request->getHeader('token')[0];

            $retorno = AutentificadoraJWT::ValidarJWT($token);//valida el token, si es valido pasa al siguiente call, si no devuelve error
            if($retorno->exito)
            {
                $retorno = json_decode(($handler->handle($request))->getBody());
            }
        }
            

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }

    public static function VerificarPropietario(Request $request, RequestHandler $handler)
    {
        $retorno = new stdClass();

        $token = $request->getHeader('token')[0];
        $retorno  = AutentificadoraJWT::ObtenerPayLoad($token);

        if($retorno->exito && $retorno->payload->perfil === 'propietario')//si se obtuvo el payload y es propietario, paso al siguinte call
        {
            $retorno = json_decode(($handler->handle($request))->getBody());
        }
        else{//si no, muestro error, con el perfil que se quiso ingresar

            if($request->getMethod() === 'PUT')
            {
                $retorno = json_decode(($handler->handle($request))->getBody());
            }
            else
            {
               $retorno->exito = false;
                $retorno->mensaje = 'Error, el usuario es '. $retorno->payload->perfil . ', debe ser propietario';
                $retorno->status = 409;
                unset($retorno->payload); 
            } 
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }

    public  function VerificarEncargado(Request $request, RequestHandler $handler)
    {
        $retorno = new stdClass();

        $token = $request->getHeader('token')[0];
        $retorno  = AutentificadoraJWT::ObtenerPayLoad($token);
        
        //Obtengo el payload y me fijo, si es encargado o propietario, y paso al siguiente call o no
        if($retorno->exito && ($retorno->payload->perfil === 'encargado'))
        {
            $retorno = json_decode(($handler->handle($request))->getBody());
        }
        else{
            if($request->getMethod() === 'PUT')
            {
                if($retorno->payload->perfil === 'propietario')
                {
                    $retorno = json_decode(($handler->handle($request))->getBody());
                }
                else
                {
                    $retorno->exito = false;
                    $retorno->mensaje = 'Error, el usuario es '. $retorno->payload->perfil .', debe ser encargado o propietario';
                    $retorno->status = 409;
                    unset($retorno->payload);
                }
            }
            else
            {
                $retorno->exito = false;
                $retorno->mensaje = 'Error, el usuario es '. $retorno->payload->perfil .', debe ser encargado';
                $retorno->status = 409;
                unset($retorno->payload);
            }
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }




    //parte 4
    public function TraerAutosEncargado(Request $request, RequestHandler $handler)
    {
        $arrayAux = array();

        $retorno = json_decode(($handler->handle($request))->getBody());

        $token = $request->getHeader('token')[0];
        $datosToken  = AutentificadoraJWT::ObtenerPayLoad($token);
        
        //si es encargado, filtro todos los datos menos el ID
        if($datosToken->exito && $datosToken->payload->perfil === 'encargado' && $retorno->exito)
        {
            foreach($retorno->tabla as $auto)
            {
                array_push($arrayAux , Auto::ConstruirAuto(null, $auto->color, $auto->marca, $auto->precio, $auto->modelo));
            }
            $retorno->tabla = $arrayAux;
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }

    public function TraerAutosEmpleados(Request $request, RequestHandler $handler)
    {
        $coloresCont = 0;

        $retorno = json_decode(($handler->handle($request))->getBody());

        $token = $request->getHeader('token')[0];
        $datosToken  = AutentificadoraJWT::ObtenerPayLoad($token);
        
        if($datosToken->exito && $datosToken->payload->perfil === 'empleado' && $retorno->exito)
        {
            //recupero el listado de autos del stdClass, haciendolo un array
            $autos = json_decode(json_encode($retorno->tabla), true);
            //Crea un nuevo array con los datos de una columna en especifico
            $colores = array_column($autos, 'color');
            //por cada elemento del array, crea un campo y cuenta cuantas veces aparece, lo guardo en lugar del listado
            $retorno->tabla = array_count_values($colores);
            //Creo un campo nuevo y cuento el total de colores distintos
            $retorno->coloresTotales = count(json_decode(json_encode($retorno->tabla), true));
            $retorno->tabla['coloresTotales'] = count(json_decode(json_encode($retorno->tabla), true));
        }
        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }


}

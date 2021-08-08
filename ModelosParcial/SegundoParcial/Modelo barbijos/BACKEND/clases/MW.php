<?php

require_once 'AccesoDatos.php';
require_once 'AutentificadorJWT.php';

class MW
{
    public function MdwLoginSeteado($request, $response, $next)
    {
        $datos = $request->getParsedBody();

        //var_dump($datos);

        if((isset($datos['user']) || isset($datos['usuario'])) && !empty($datos))
        {
            $newResponse = $next($request, $response);
        }
        else
        {
            $newResponse = $response->withJson(["mensaje" => "Error, datos no seteados."], 403);
        }
        
        return $newResponse;
    }

    public static function MdwLoginVacio($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        
        if(isset($datos['user']))
            $jsonDatos = $datos['user'];
        else
            $jsonDatos = $datos['usuario'];
        
        $usuario = json_decode($jsonDatos);

        if(strlen($usuario->correo) == 0 && strlen($usuario->clave) == 0)
        {
            $newResponse = $response->withJson(["mensaje" => "Error, datos vacios."], 409);
        }
        else if(strlen($usuario->correo) == 0){
            $newResponse = $response->withJson(["mensaje" => "Error, correo vacio."], 409);
        }
        else if(strlen($usuario->clave) == 0){
            $newResponse = $response->withJson(["mensaje" => "Error, clave vacia."], 409);
        }
        else
        {
            $newResponse = $next($request, $response);
        }

        return $newResponse;
    }

    public function MdwVerificarBaseDeDatos($request, $response, $next)
    {
        $datos = $request->getParsedBody();

        $jsonDatos = $datos['user'];
        $usuario = json_decode($jsonDatos);

        $usuarioCompleto = Usuarios::traerUsuarioPorEmailClave($usuario);

        if(empty($usuarioCompleto))
        {
            $newResponse = $response->withJson(["mensaje" => "Error, el mail y clave no se encuentran en nuestra base de datos."], 403);
        }
        else
        {
            $newResponse = $next($request, $response);
        }

        return $newResponse;
    }

    public static function MdwVerificarMailBaseDeDatos($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        
        if (isset($datos['user'])) {
            $jsonDatos = $datos['user'];    
        }
        else
        {
            $jsonDatos = $datos['usuario'];
        }
        
        
        
        $usuario = json_decode($jsonDatos);

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE correo=:correo");

        $consulta->bindValue(":correo",$usuario->correo);
        $consulta->execute();
        
        //si retorno algo, es porque se encontro el la base de datos, osea ya existe un usuario con ese mail
        if($consulta->fetchAll(PDO::FETCH_ASSOC))
        {
            $newResponse = $response->withJson(["mensaje" => "Error, el mail ya existe."], 403);
        }
        //Si no, on existe un usario con ese mail, pasa al siguiente calleable que es el alta
        else
        {
            $newResponse = $next($request, $response);
        }

        return $newResponse;  
    }
/*
    public function VerificarToken($request, $response, $next)
    {
        $headers = getallheaders();
        
        if(AutentificadorJWT::VerificarToken($headers["token"]))
        {
            $newResponse = $next($request, $response);
        }
        else
        {
            $newResponse = $response->withJson(["mensaje" => "Error, token invalido."], 403);
        }
        
        return $newResponse;
    }

    public function MdwVerificarPrecioColor($request, $response, $next)
    {   
        $flagPrecio = 0;
        $flagColor = 0;

        $datos = $request->getParsedBody();
        $jsonDatos = $datos['auto'];
        $auto = json_decode($jsonDatos);

        $jsonRespuesta = new StdClass();

        if($auto->precio<50000 || $auto->precio > 600000)
        {
            $flagPrecio = 1;  
        }

        if(strtolower($auto->color) == "azul")
        {
            $flagColor = 1;
        }

        if($flagPrecio==1 && $flagColor==0)
        {
            $jsonRespuesta->mensaje = "El precio del auto debe estar entre 50000 y 600000.";
        }
        else if($flagPrecio==0 && $flagColor ==1)
        {
            $jsonRespuesta->mensaje = "El auto no debe ser de color azul.";
        }
        else if($flagPrecio==1 && $flagColor ==1)
        {
            $jsonRespuesta->mensaje = "El precio del auto debe estar entre 50000 y 600000 y el auto no debe ser de color azul.";
        }

        $newResponse = $response->withJson($jsonRespuesta, 409);
        
        if($flagPrecio==0 && $flagColor ==0)
        {   
            $newResponse = $next($request, $response);
        }

        return $newResponse;
    }

    public static function MdwVerificarPropietario($request, $response, $next)
    {
        $headers = getallheaders();
        $jwt = $headers["token"];
        $jsonRespuesta = new StdClass();

        $user = AutentificadorJWT::DecodificarToken($jwt);
        if(strtolower($user->perfil)=="propietario")
        {
            $jsonRespuesta->propietario = true;
            $jsonRespuesta->mensaje = "El usuario es propietario";
            //$newResponse = $response->withJson($jsonRespuesta, 200);
            $newResponse = $next($request, $response);
        }
        else
        {
            $jsonRespuesta->propietario = false;
            $jsonRespuesta->mensaje = "El usuario no es propietario";
            $newResponse = $response->withJson($jsonRespuesta, 409);
            //$newResponse = $next($request, $response->withJson($jsonRespuesta, 409));
        }

        return $newResponse;
    }

    public function MdwVerificarEncargado($request, $response, $next)
    {
        $headers = getallheaders();
        $jwt = $headers["token"];
        $jsonRespuesta = new StdClass();

        $user = AutentificadorJWT::DecodificarToken($jwt);

        if(strtolower($user->perfil)=="encargado")
        {
            $jsonRespuesta->encargado = true;
            $jsonRespuesta->mensaje = "El usuario es encargado";
            //$newResponse = $response->withJson($jsonRespuesta, 200);
            $newResponse = $next($request, $response);
        }
        else
        {
            $jsonRespuesta->encargado = false;
            $jsonRespuesta->mensaje = "El usuario no es encargado";
            $newResponse = $response->withJson($jsonRespuesta, 409);
        }

        return $newResponse;
    }*/
}
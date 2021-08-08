<?php

require_once 'AccesoDatos.php';
require_once 'AutentificadorJWT.php';

class Usuarios
{
    public static function Alta($request, $response, $args)
    { 
        $datos = $request->getParsedBody();

        $jsonDatos = $datos['usuario'];
        $usuario = json_decode($jsonDatos);
        
        $fotos = $request->getUploadedFiles();
        $nombreFoto = $fotos["foto"]->getClientFileName();
        $ubicacionFoto = "./fotos/".$usuario->correo.".".pathinfo($nombreFoto, PATHINFO_EXTENSION);
        $fotos["foto"]->moveTo($ubicacionFoto);
        $ubicacionFoto = $usuario->correo.".".pathinfo($nombreFoto, PATHINFO_EXTENSION);
        /*$foto=$fotos["foto"];
        $ubicacionFoto = "./fotos/".date("dis").".".pathinfo($foto, PATHINFO_EXTENSION);*/
        /*if($foto!="")
        copy($foto, $ubicacionFoto);*/
        
        $correo = $usuario->correo;
        $clave = $usuario->clave;
        $nombre = $usuario->nombre;
        $apellido = $usuario->apellido;
        $perfil = $usuario->perfil;
        $foto = $ubicacionFoto;

        $json = new stdClass();  
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into  
        usuarios (correo, clave, nombre, apellido, perfil, foto)
        values(:correo, :clave, :nombre, :apellido, :perfil, :foto)");

        $consulta->bindValue(':correo',$correo);
        $consulta->bindValue(':clave', $clave);
        $consulta->bindValue(':nombre', $nombre);
        $consulta->bindValue(':apellido', $apellido);
        $consulta->bindValue(':perfil', $perfil);
        $consulta->bindValue(':foto', $foto);

        if($consulta->execute())
        {
            $json->exito=true; 
            $json->mensaje="OK"; 

            $newResponse = $response->withJson($json, 200);
        }
        else
        {
            $json->exito=false; 
            $json->mensaje="No se pudo añadir."; 

            $newResponse = $response->withJson($json, 418);
        }      

        return $newResponse;
    }

    public static function Listado($request, $response, $args)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT correo, nombre, apellido, perfil, foto FROM usuarios");
        $json = new stdClass();  

        if($consulta->execute()){
            $retorno= $consulta->fetchAll(PDO::FETCH_CLASS, "Usuarios");	

            $json->exito=true; 
            $json->mensaje="OK";
            $json->tabla = $retorno;

            $newResponse = $response->withJson($json, 200);
        }else{
            $json->exito=false; 
            $json->mensaje="Error";
            $json->tabla = "";

            $newResponse = $response->withJson($json, 424);
        }

        return $newResponse;
    }

    public static function CrearJWT($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $jsonDatos = $datos['user'];
        $usuario = json_decode($jsonDatos);
        $json = new stdClass();

        $usuarioCompleto = Usuarios::traerUsuarioPorEmailClave($usuario);

        if($usuarioCompleto!=null)
        {
            $usuarioCompletophp = new stdClass();
            $usuarioCompletophp->correo = $usuarioCompleto[0]["correo"];
            $usuarioCompletophp->clave = $usuarioCompleto[0]["clave"];
            $usuarioCompletophp->nombre = $usuarioCompleto[0]["nombre"];
            $usuarioCompletophp->apellido = $usuarioCompleto[0]["apellido"];
            $usuarioCompletophp->perfil = $usuarioCompleto[0]["perfil"];
            $usuarioCompletophp->foto = $usuarioCompleto[0]["foto"];

            $jwt = AutentificadorJWT::CrearToken($usuarioCompletophp);

            if($jwt != "")
                {
                    $json->exito=true; 
                    $json->jwt = $jwt;
                    $newResponse = $response->withJson($json,200);
                }
            }
        
        else
        {
            $json->exito=false; 
            $json->jwt = null;
            $newResponse = $response->withJson($json,403);
        }
        

        return $newResponse;
       
    }

    public static function traerUsuarioPorEmailClave($usuario)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE correo=:correo AND clave=:clave");

        $consulta->bindValue(":correo",$usuario->correo);
        $consulta->bindValue(":clave",$usuario->clave);

        $consulta->execute();
        
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $datos;     
    }

    public static function VerificarJWT($request, $response, $next)
    {
        $headers = getallheaders();
        $json = new stdClass();

        if(AutentificadorJWT::VerificarToken($headers["token"]))
        {
            $json->exito=true; 
            $json->mensaje = "Usuario validado.";
            /*$objeto = AutentificadorJWT::DecodificarToken($headers["token"]);
            $json->perfil = $objeto->perfil;*/
            $newResponse = $response->withJson($json,200);
        }
        else
        {
            $json->exito=false; 
            $json->mensaje = "Usuario no validado.";
            $newResponse = $response->withJson($json,403);
        }

        return $newResponse;
    }

    /*public function DecodificarToken($request, $response, $next)
    {
        $datos = $request->getParsedBody();
        $token = $datos['jwt'];

        return AutentificadorJWT::DecodificarToken($token);
    }*/
}
?>
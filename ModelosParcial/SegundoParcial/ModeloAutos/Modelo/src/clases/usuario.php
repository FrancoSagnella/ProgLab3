<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once 'accesodatos.php';
require_once 'autentificadoraJWT.php';
require_once 'MW.php';

class Usuario{
    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $foto;
    public $id_perfil;
    public $perfil;
    public $clave;
    
    public static function construirUsuario($id, $nombre, $apellido, $correo, $foto, $id_perfil, $perfil, $clave)
    {   
        $user = new Usuario();
        $user->id = $id;
        $user->nombre = $nombre;
        $user->apellido  = $apellido;
        $user->correo = $correo;
        $user->foto = $foto;
        $user->id_perfil = $id_perfil;
        $user->perfil = $perfil;
        $user->clave = $clave;

        return $user;
    }

    public static function Alta(Request $request,Response $response, $args)
    {
        //seteo el json re retorno
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Error agregando el usuario";
        $retorno->status = 418;
        $status = 418;

        //recupero los parametros (como es por post, vienen en el parsedBody)
        $params = $request->getParsedBody();
        $json_usuario = json_decode($params['obj_json']);

        //recupero la foto
        $fotos = $request->getUploadedFiles();
        $newPath = Usuario::GenerarNombreFoto($fotos, $json_usuario->correo);

        $user = Usuario::construirUsuario(null, $json_usuario->nombre, $json_usuario->apellido, $json_usuario->correo, $newPath, $json_usuario->id_perfil, null, $json_usuario->clave);

        if($user->AgregarUsuario())
        {
            //si se agrego el usuario, solo si el path de la foto no era null, la muevo
            if($newPath !== null)
            {
                $fotos["foto"]->moveTo("../src/fotos/".$newPath);
            }

            $retorno->exito = true;
            $retorno->mensaje = "Usuario agregardo con exito";
            $retorno->status = 200;
            $status = 200;
        }

        //retorno la respuesta con formato json
        $newResponse = $response->withStatus($status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function AgregarUsuario()
    {
        $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, apellido, id_perfil, foto) VALUES (:correo, :clave, :nombre, :apellido, :id_perfil, :foto)");

                $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
                $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(":apellido", $this->apellido, PDO::PARAM_STR);
                $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
                $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);

                $consulta->execute();

                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
    }

    public static function GenerarNombreFoto($fotos, $correo)
        {
            $ret = null;
            if($fotos != null){

                $tempPath = $fotos["foto"]->getClientFileName();
                $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
                $ret = $correo . "." . date("Gis") . "." . $extension;
            }
            return $ret;
        }

    public static function Listado(Request $request,Response $response, $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Error al cargar el listado";
        $retorno->tabla = "";
        $retorno->status = 418;
        $status = 418;

        $tabla = Usuario::TraerUsuarios();
        if($tabla !== false)
        {
            $retorno->exito = true;
            $retorno->mensaje = "Listado cargado";
            $retorno->tabla = $tabla;
            $retorno->status = 200;
            $status = 200;
        }

        $newResponse = $response->withStatus($status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function TraerUsuarios()
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.apellido, usuarios.foto, usuarios.id_perfil, perfiles.perfil FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.id_perfil");
            $consulta->execute();

            //me devuelve un array de la clase usuario con todo lo que trajo de la bbdd
            $ret = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");

            if (isset($ret)) {
                return $ret;
            } else {
                return false;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function CrearJWT(Request $request,Response $response, $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->jwt = null;
        $retorno->status = 403;
        $status = 403;

        //recupero correo y clave recibidos por post
        $params = $request->getParsedBody();
        $json_usuario = json_decode($params['obj_json']);
        $correo = $json_usuario->correo;
        $clave = $json_usuario->clave;

        $usuario = Usuario::TraerUnUsuario($correo, $clave);
        if($usuario != false)
        {
            $status = 200;
            $retorno->status = 200;
            $retorno->exito = true;
            $retorno->jwt = AutentificadoraJWT::CrearJWT($usuario[0]);
        }

        $newResponse = $response->withStatus($status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function VerificarJWT(Request $request,Response $response, $args)
    {
        $retorno = new stdClass();
        $retorno->exito = FALSE;
        $retorno->mensaje = "no se envio token";
        $status = 403;

        $array = $request->getHeader('token');
        if(isset($array[0]))
        {
            $token = $array[0];
            $retorno = AutentificadoraJWT::ValidarJWT($token);
        }
        
        $newResponse = $response->withStatus($status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    //traigo uno con correo y clave, para verificar que exista
    public static function TraerUnUsuario($correo, $clave)
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.apellido, usuarios.foto, usuarios.id_perfil, perfiles.perfil FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.id_perfil WHERE usuarios.correo = :correo AND usuarios.clave = :clave");
            
            $consulta->bindValue(":correo", $correo, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $clave, PDO::PARAM_INT);

            $consulta->execute();

            //me devuelve un array de la clase usuario con todo lo que trajo de la bbdd
            $ret = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");

            if (isset($ret)) {
                return $ret;
            } else {
                return false;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

}
<?php
//para poder usar las clases de Slim
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once 'accesodatos.php';
require_once 'autentificadoraJWT.php';
require_once 'MW.php';

class Usuario
{
    public $id;
    public $correo;
    public $clave;
    public $nombre;
    public $apellido;
    public $perfil;
    public $foto; 

    public static function ConstruirUsuario($id, $correo, $clave, $nombre, $apellido, $perfil, $foto)
    {
        $auto = new Usuario();
        $auto->id = $id;
        $auto->correo = $correo;
        $auto->clave = $clave;
        $auto->nombre = $nombre;
        $auto->apellido = $apellido;
        $auto->perfil = $perfil;
        $auto->foto = $foto;

        return $auto;
    } 

    public static function Agregar(Request $request,Response $response, $args)
    {
        //defino el retorno
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo agregar el Usuario';
        $retorno->status = 418;

        //obtengo los datos
        $params = $request->getParsedBody();
        $json_usuario = json_decode($params['usuario']);

        
        
        $usuario = Usuario::ConstruirUsuario(null, $json_usuario->correo, $json_usuario->clave, $json_usuario->nombre, $json_usuario->apellido, $json_usuario->perfil, null);
        if(($id = $usuario->AgregarUsuario()) !== false)
        {
            //obtengo la foto
            $foto = $request->getUploadedFiles();
            $newPath = Usuario::GenerarNombreFoto($foto, $json_usuario->correo, $id);

            if($newPath !== null)
            {
                $foto["foto"]->moveTo("./fotos/".$newPath);
                Usuario::ActualizarBDFoto($newPath, $id);
            }

            $retorno->exito = true;
            $retorno->mensaje = 'Usuario agregado con exito';
            $retorno->status = 200;
        }

        //armo la respuesta
        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function Lista(Request $request,Response $response, $args)
    {
        //defino el retorno
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo obtener el Listado';
        $retorno->datos = '';
        $retorno->status = 424;

        if(($listado = Usuario::TraerUsuarios()) !== false)
        {
            $retorno->exito = true;
            $retorno->mensaje = 'Listado obtenido con exito';
            $retorno->datos = $listado;
            $retorno->status = 200;
        }

        //armo la respuesta
        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function CrearJWT(Request $request,Response $response, $args)
    {
        //defino el retorno
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo crear el JWT';
        $retorno->jwt = null;
        $retorno->status = 403;

        //obtengo los datos
        $params = $request->getParsedBody();
        $json_usuario = json_decode($params['user']);
        $correo = $json_usuario->correo;
        $clave = $json_usuario->clave;

        //proceso los datos
        $usuario = Usuario::TraerUnUsuario($correo, $clave);
        if($usuario !== false)
        {
            $retorno->status = 200;
            $retorno->exito = true;
            $retorno->mensaje = 'Sesion iniciada';
            $retorno->jwt = AutentificadoraJWT::CrearJWT($usuario[0]);
        }

        //armo la respuesta
        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function VerificarJWT(Request $request,Response $response, $args)
    {
        //defino el retorno
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se envio token';
        $retorno->status = 403;

        
        $jwt = $request->getHeader('token');
        if(isset($jwt[0]))
        {
            $retorno = AutentificadoraJWT::ValidarJWT($jwt[0]);
        }

        //armo la respuesta
        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function AgregarUsuario()
    {
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, apellido, perfil, foto) VALUES (:correo, :clave, :nombre, :apellido, :perfil, :foto)");

                $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
                $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
                $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(":apellido", $this->apellido, PDO::PARAM_STR);
                $consulta->bindValue(":perfil", $this->perfil, PDO::PARAM_STR);
                $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);

                $consulta->execute();

                $ret = $AccesoDatos->RetornarultimoIdInsertado();

            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
    }

    public static function GenerarNombreFoto($fotos, $correo, $id)
    {
        $ret = null;
        if($fotos != null){
            $tempPath = $fotos["foto"]->getClientFileName();
            $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
            $ret = $correo . "_" . $id . "." . $extension;
        }
        return $ret;
    }

    public static function ActualizarBDFoto($newPath, $id)
    {
        try{
		    $objetoAccesoDato = AccesoDatos::TraerAccesoDatos(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET foto=:foto WHERE id=:id");

		    $consulta->bindValue(':id',$id, PDO::PARAM_INT);
            $consulta->bindValue(':foto',$newPath, PDO::PARAM_STR);

            //devuelve true si se ejectuo bien, false si no
		    return $consulta->execute();
        }
        catch (Exception $e){
            echo $e->getMessage();
            return false;
        }
    }

    public static function TraerUsuarios()
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT id, correo, clave, nombre, apellido, perfil, foto FROM usuarios");
            $consulta->execute();

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

    public static function TraerUnUsuario($correo, $clave)
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE correo = :correo AND clave = :clave");
            
            $consulta->bindValue(":correo", $correo, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $clave, PDO::PARAM_INT);

            $consulta->execute();

            $ret = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");

            if (isset($ret[0])) {
                return $ret;
            } else {
                return false;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function TraerUnUsuarioCorreo($correo)
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT * FROM usuarios WHERE correo = :correo");
            
            $consulta->bindValue(":correo", $correo, PDO::PARAM_STR);

            $consulta->execute();

            $ret = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");

            if (isset($ret[0])) {
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
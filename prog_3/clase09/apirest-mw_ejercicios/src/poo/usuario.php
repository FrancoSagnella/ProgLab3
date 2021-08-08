<?php
//Tengo que agregar estos uses, tambien asi puedo usar los tipos Response y Request
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function FastRoute\TestFixtures\no_options_cached;

require_once "accesodatos.php";

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

    public function TraerTodos(Request $request, Response $response, array $args): Response{
        if(($user_array = Usuario::TraerTodosLosUsuarios()) != false)
        {
            $newResponse = $response->withStatus(200, "OK");
            //con esto ya devuelvo el array que me trajo el traerTodos a un string json
		    $newResponse->getBody()->write(json_encode($user_array));
        }
        else{
            $newResponse = $response->withStatus(403, "Error del servidor");
		    $newResponse->getBody()->write(json_encode('{"mensaje":"ERROR no se conecto con la bd"}'));
        }
        return $newResponse->withHeader('Content-type', 'application/json') ;
    }

    public static function TraerTodosLosUsuarios(){
        try {
            $AccesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.apellido, usuarios.foto, usuarios.id_perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.id_perfil");
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $user_array[] = Usuario::construirUsuario($row['id'], $row['nombre'], $row['apellido'], $row['correo'], $row['foto'], $row['id_perfil'], $row['descripcion'], $row['clave']);
            }
            if (isset($user_array)) {
                return $user_array;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
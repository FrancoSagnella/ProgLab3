<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class Usuario
{
    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $foto;
    public $id_perfil;
    public $clave;

    public function TraerTodos(Request $request, Response $response, array $args) : Response 
	{
		$todosLosUsuarios = Usuario::ObtenerTodos();

		$newResponse = $response->withStatus(200);

        $newResponse->getBody()->write(json_encode($todosLosUsuarios));
    
        return $newResponse->withHeader('Content-Type', 'application/json');
	}
    
	private static function ObtenerTodos()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, nombre, apellido, correo, foto, id_perfil from mi_base.usuarios");
		$consulta->execute();			
		return $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");		
	}

	public static function ObtenerUsuario($objUser)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, nombre, apellido, correo, foto, id_perfil 
														from mi_base.usuarios where correo=:correo and clave=:clave");

		$consulta->bindValue(':correo',$objUser->correo, PDO::PARAM_STR);
		$consulta->bindValue(':clave', $objUser->clave, PDO::PARAM_STR);

		$consulta->execute();			
		return $consulta->fetchObject('usuario');
	}
}
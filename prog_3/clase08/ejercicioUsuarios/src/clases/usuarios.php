<?php
//Tengo que agregar estos uses, tambien asi puedo usar los tipos Response y Request
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use function FastRoute\TestFixtures\no_options_cached;

require_once "AccesoDatos.php";
require_once "Islim.php";

class Usuario implements Islim{

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
    //IMPLEMENTO LAS FUNCIONES DE LA INTERFAZ
    //ESTAS VAN A SER LAS FUNCIONES QUE USE DESDE LA API
    //ACA DEBERIA DE HACER LAS VALIDACIONES NECESARIAS Y LLAMAR A ALGUN METODO PARA CONECTARME A LA BD
    //ESTOS METODOS NO SE DEBERIAN CONECTAR DIRECTAMENTE A LA BD
    //ESTAS FUNCIONES HARIAN LO QUE HACIA ANTES EN PAGINAS SEPARADAS TIPO ALTA.PHP etc.
    //LO QUE HAGO AHORA ES EN VEZ DE TENER QUE HACER LAS PETICIONES A DIFERENTES PAGINAS,
    //HAGO TODAS LAS PETICIONES A LA LAPINA APP.PHP, Y DEPENDIENDO DE LA ACCION QUE LE ENVIE 
    //VA A ENTRAR A ALGUNA DE ESTAS FUNCIONES

    //En los retornos de los metodos, voy a intentar responder siempre con un json
    //que indique true o fals y lo que paso, o devuelva los objetos que tenga que devolver
    public function TraerTodos(Request $request, Response $response, array $args): Response
    {
        if(($user_array = Usuario::TraerTodosUsuarios()) != false)
        {
            $newResponse = $response->withStatus(200, "OK");
		    $newResponse->getBody()->write(json_encode($user_array));
        }
        else{
            $newResponse = $response->withStatus(500, "Error del servidor");
		    $newResponse->getBody()->write("No se pudieron traer los datos de la base de datos");
        }
        return $newResponse;
    }


    public function TraerUno(Request $request, Response $response, array $args): Response
    {
        if(($user_array = Usuario::TraerUnUsuario($args['id'])) != false)
        {
            $newResponse = $response->withStatus(200, "OK");
		    $newResponse->getBody()->write(json_encode($user_array));
        }
        else{
            $newResponse = $response->withStatus(500, "Error del servidor");
		    $newResponse->getBody()->write("No se encontro el usuario solicitado");
        }
        return $newResponse;
    }


    public function AgregarUno(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody();
        $archivos = $request->getUploadedFiles();
        //Primero agarro todos los parametros que recibi en el cuarpo de la peticion
        //los valido
        $correo = isset($params['correo']) ? $params['correo'] : false;
        $clave = isset($params['clave']) ? $params['clave'] : false;
        $nombre= isset($params['nombre']) ? $params['nombre'] : false;
        $apellido= isset($params['apellido']) ? $params['apellido'] : false;
        $foto= isset($archivos['foto']) ? $archivos['foto'] : false;
        $id_perfil = isset($params['id_perfil']) ? $params['id_perfil'] : false;
    
        $ret = new stdClass();
        $ret->exito = false;
        $ret->mensaje = "No se recibieron los parametros necesarios POST";
    
        if($correo != false && $clave != false && $nombre != false && $id_perfil != false && $apellido != false && $foto != false)
        {  
            $ret->mensaje = "No se pudo agregar el usuario";
            //si recibi todo, valido que el usuario que vaya a entregar no exista ya en la bd
            //Si devuelve false, es porque no lo encontro, no existe, hago el alta
            if(Usuario::TraerUnUsuarioJSON(json_encode(array("correo" => $correo, "clave" => $clave))) == false)
            {
                $user = Usuario::construirUsuario(null, $nombre, $apellido, $correo, Usuario::generarNombreFoto($foto, $apellido), $id_perfil, null, $clave);
                if($user->AgregarUsuario() != false && $user->GuardarFoto($foto))
                {
                    $ret->exito = true;
                    $ret->mensaje = "Usuario agregado con exito";
                    $newResponse = $response->withStatus(200, "OK");
                }
                else{
                    $newResponse = $response->withStatus(500, "Error al agregar");
                }
            }
            else{//Si devolvio un usuario existe uno ya en la base de datos igual
                $ret->mensaje = "El usuario ya existe";
                $newResponse = $response->withStatus(501, "Usuario repetido");
            }
        }
        
        $newResponse->getBody()->write(json_encode($ret));
        return $newResponse;
    }


    public function ModificarUno(Request $request, Response $response, array $args): Response
    {
        $user_json = isset($args['json']) ? json_decode($args['json']) : false;

        $ret = new stdClass();
        $ret->exito = false;
        $ret->mensaje = "No se recibieron parametros necesarios";
        $newResponse = $response->withStatus(501, "Error al modificar");

        if($user_json != false)
        {
            $ret->mensaje = "No existia un usuario con ese id";
            if(($user_aux = Usuario::TraerUnUsuario($user_json->id)) != false)
            {
                $user = Usuario::construirUsuario($user_json->id, $user_json->nombre, $user_json->apellido, $user_json->correo, $user_aux->foto, $user_json->id_perfil, null, $user_json->clave);
                if($user->ModificarUsuario() != false)
                {
                    $ret->exito = true;
                    $ret->mensaje = "Usuario modificado con exito";
                    $newResponse = $response->withStatus(200, "OK");
                }
                else{
                    $ret->mensaje = "No se pudo modificar al usuario";
                    $newResponse = $response->withStatus(500, "Error al modificar");
                }
            }
        }

        $newResponse->getBody()->write(json_encode($ret));
        return $newResponse;
    }


    public function BorrarUno(Request $request, Response $response, array $args): Response
    {
        $id = isset($args['id']) ? $args['id'] : false;

        $ret = new stdClass();
        $ret->exito = false;
        $ret->mensaje = "No se recibieron los parametros";
        $newResponse = $response->withStatus(501, "Error al eliminar");

        if($id != false)
        {
            if(Usuario::EliminarUsuario($id))
            {
                $ret->exito = true;
                $ret->mensaje = "empleado eliminado";
                $newResponse = $response->withStatus(501, "usuario eliminado");
            }
            else{
                $ret->mensaje = "No se pudo eliminar";
            }
        }

        $newResponse->getBody()->write(json_encode($ret));
        return $newResponse;
    }


    public function Login(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody();

        $correo = isset($params['correo']) ? $params['correo'] : false;
        $clave = isset($params['clave']) ? $params['clave'] : false;

        $ret = new stdClass();
        $ret->exito = false;
        $ret->mensaje = "No se recibieron los parametros necesarios POST";
    
        if($correo != false && $clave != false)
        { 
            if(Usuario::TraerUnUsuarioJSON(json_encode(array("correo" => $correo, "clave" => $clave))) == false)
            {
                $ret->mensaje = "El correo y clave no coinciden on un usuario";
                $newResponse = $response->withStatus(400, "OKn`t");
            }
            else{//Si devolvio un usuario existe uno ya en la base de datos igual
                $ret->exito = true;
                $ret->mensaje = "Logueado con exito";
                $newResponse = $response->withStatus(200, "OK");
            }
        }

        $newResponse->getBody()->write(json_encode($ret));
        return $newResponse;
    }
    //IMPLEMENTO METODOS PARA ESTABLECER LAS CONEXIONES CON LA BASE DE DATOS
    //los select van a ser estaticos
    public static function TraerTodosUsuarios()
    {
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

    public static function TraerUnUsuario($id)
    {
        try {
            $AccesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre,usuarios.apellido, usuarios.foto, usuarios.id_perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.id_perfil WHERE usuarios.id = :id");

            $consulta->bindValue(":id", $id);

            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $user =  Usuario::construirUsuario($row['id'], $row['nombre'], $row['apellido'], $row['correo'], $row['foto'], $row['id_perfil'], $row['descripcion'], $row['clave']);            }

            if (isset($user)) {
                return $user;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function TraerUnUsuarioJSON($params)
    {
        $obj = json_decode($params);
        if (!isset($obj))
            return false;
        try {
            $AccesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre,usuarios.apellido, usuarios.foto, usuarios.id_perfil, perfiles.descripcion FROM `usuarios` INNER JOIN `perfiles` ON perfiles.id=usuarios.id_perfil WHERE usuarios.correo = :correo AND usuarios.clave = :clave");

            $consulta->bindValue(":correo", $obj->correo);
            $consulta->bindValue(":clave", $obj->clave);

            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $user =  Usuario::construirUsuario($row['id'], $row['nombre'], $row['apellido'], $row['correo'], $row['foto'], $row['id_perfil'], $row['descripcion'], $row['clave']);            }

            if (isset($user)) {
                return $user;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //estos pueden ser de instancia asi no reciben parametros
    public function AgregarUsuario()
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, apellido, foto, id_perfil) VALUES (:correo, :clave, :nombre, :apellido, :foto, :id_perfil)");

            $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":apellido", $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    public function ModificarUsuario()
    {
        $ret = false;
        try {
            $AccesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $AccesoDatos->RetornarConsulta("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, apellido = :apellido, foto = :foto, id_perfil = :id_perfil WHERE id = :id");

            $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            $consulta->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(":clave", $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(":apellido", $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(":foto", $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    public static function EliminarUsuario($id)
    {
        $ret = false;
        try{
            $AccesoDatos = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");

            $consulta->bindValue(":id", $id, PDO::PARAM_INT);

            $consulta->execute();

            $ret = true;
        }catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    public static function generarNombreFoto($foto, $apellido)
    {
        $nombreAnterior = $foto->getClientFilename();

        $extension = explode(".", $nombreAnterior);
        $extension = array_reverse($extension);

        $nuevoNombre = $apellido . date("Gis") . "." . $extension[0];

        return $nuevoNombre;
    }

    public function GuardarFoto($foto)
    {
        try{
            $foto->moveTo(__DIR__ . "/../fotos/" . $this->foto);
            return true;
        }catch(Exception $e)
        {
            echo $e->getMessage();
            return false;
        } 
    }
}
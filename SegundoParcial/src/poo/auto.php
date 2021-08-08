<?php
//para poder usar las clases de Slim
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//Puedo usar la clase responseMW (los objetos response que provienen delos middlewares)
use Slim\Psr7\Response as ResponseMW;

require_once 'accesodatos.php';
require_once 'MW.php';

class Auto
{
    public $id;
    public $color;
    public $marca;
    public $precio;
    public $modelo; 

    public static function ConstruirAuto($id, $color, $marca, $precio, $modelo)
    {
        $auto = new Auto();
        $auto->id = $id;
        $auto->color = $color;
        $auto->marca = $marca;
        $auto->precio = $precio;
        $auto->modelo = $modelo;

        return $auto;
    } 

    public static function TraerTodos(Request $request,Response $response, $args)
    {
        //defino el retorno
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo obtener el Listado';
        $retorno->datos = '';
        $retorno->status = 424;

        if(($listado = Auto::TraerAutos()) !== false)
        {
            $retorno->exito = true;
            $retorno->mensaje = 'Listado obtenido con exito';
            $retorno->datos = $listado;
            $retorno->status = 200;

            if(isset($args['id_auto']))
            {
                $retorno->id = $args['id_auto'];
            }
        }

        //armo la respuesta
        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function Agregar(Request $request,Response $response, $args)
    {
        //defino el retorno
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo agregar el Auto';
        $retorno->status = 418;

        //obtengo los datos
        $params = $request->getParsedBody();
        $json_auto = json_decode($params['auto']);
        
        //proceso los datos (creo auto y lo subo a la bd)
        $auto = Auto::ConstruirAuto(null, $json_auto->color, $json_auto->marca, $json_auto->precio, $json_auto->modelo);
        if($auto->AgregarAuto())
        {
            $retorno->exito = true;
            $retorno->mensaje = 'Auto agregado con exito';
            $retorno->status = 200;
        }

        //armo la respuesta
        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function Modificar(Request $request,Response $response, $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo modificar el auto';
        $retorno->status = 418;

        //paso los datos del auto por el body en raw
        $params = json_decode($request->getBody()->getContents());
        //$params = $request->getParsedBody();
        //$params = $_POST;
        //$json = $params["auto"];
        //$params = json_decode($request->getHeader('auto')[0]);
        //$params = json_decode($args['auto']);
        //paso el id del auto a modificar por la ruta
        //$id = $args['id_auto'];
        $auto = Auto::ConstruirAuto($params->id, $params->color, $params->marca, $params->precio, $params->modelo);

        if(($auto->ModificarAuto()))
        {
            $retorno->exito = true;
            $retorno->mensaje = 'Auto modificado';
            $retorno->status = 200;
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }

    public static function Eliminar(Request $request,Response $response, $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = 'No se pudo eliminar el auto';
        $retorno->status = 418;

        $params = $request->getBody()->getContents();
        $auto = Auto::ConstruirAuto($params, null,null,null,null);

        //devuelve el numero de filas, si devuelve 0 no entra
        if(($auto->BorrarAuto()))
        {
            $retorno->exito = true;
            $retorno->mensaje = 'Auto borrado';
            $retorno->status = 200;
        }

        $newResponse = new ResponseMW($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-type', 'application/json');
    }

    public function AgregarAuto()
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO autos (color, marca, precio, modelo) VALUES (:color, :marca, :precio, :modelo)");

            $consulta->bindValue(":color", $this->color, PDO::PARAM_STR);
            $consulta->bindValue(":marca", $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(":precio", $this->precio, PDO::PARAM_STR);
            $consulta->bindValue(":modelo", $this->modelo, PDO::PARAM_STR);

            $ret = $consulta->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $ret;
    }

    public static function TraerAutos()
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT id, color, marca, precio, modelo FROM autos");
            $consulta->execute();

            //me devuelve un array de la clase usuario con todo lo que trajo de la bbdd
            $ret = $consulta->fetchAll(PDO::FETCH_CLASS, "Auto");

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

    public static function TraerUnAuto($id)
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT * FROM autos WHERE id = :id");
            
            $consulta->bindValue(":id", $id, PDO::PARAM_INT);

            $consulta->execute();

            //me devuelve un array de la clase auto con todo lo que trajo de la bbdd
            $ret = $consulta->fetchAll(PDO::FETCH_CLASS, "Auto");

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

    public function ModificarAuto()
	{
        try{
		    $objetoAccesoDato = AccesoDatos::TraerAccesoDatos(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE autos SET color=:color, marca=:marca, precio=:precio, modelo=:modelo WHERE id=:id");

		    $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
		    $consulta->bindValue(':color',$this->color, PDO::PARAM_STR);
		    $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
		    $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
		    $consulta->bindValue(':modelo', $this->modelo, PDO::PARAM_STR);

            //devuelve true si se ejectuo bien, false si no
		    return $consulta->execute();
        }
        catch (Exception $e){
            echo $e->getMessage();
            return false;
        }

	 }

	public function BorrarAuto()
	{
        try{
	 	    $objetoAccesoDato = AccesoDatos::TraerAccesoDatos(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM autos WHERE id=:id");	
		    $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
		    $consulta->execute();

            //devuelve el numero de filas borradas
		    return $consulta->rowCount();
        }
        catch (Exception $e){
            echo $e->getMessage();
            return false;
        }
	}
}
<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once 'accesodatos.php';
require_once 'MW.php';

class Auto{
    public $id;
    public $color;
    public $marca;
    public $precio;
    public $modelo;

    public static function construirAuto($id, $color, $marca, $precio, $modelo)
    {
        $auto = new Auto();
        $auto->id = $id;
        $auto->color = $color;
        $auto->marca  = $marca;
        $auto->precio = $precio;
        $auto->modelo = $modelo;

        return $auto;
    }

    public static function Alta(Request $request,Response $response, $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Error agregando el auto";
        $retorno->status = 418;
        $status = 418;

        $params = $request->getParsedBody();
        $json_auto = json_decode($params['obj_json']);

        $auto = Auto::construirAuto(null, $json_auto->color, $json_auto->marca, $json_auto->precio, $json_auto->modelo);

        if($auto->AgregarAuto())
        {
            $retorno->exito = true;
            $retorno->mensaje = "Auto agregardo con exito";
            $retorno->status = 200;
            $status = 200;
        }

        $newResponse = $response->withStatus($status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public function AgregarAuto()
    {
        $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("INSERT INTO autos (color, marca, precio, modelo) VALUES (:color, :marca, :precio, :modelo)");

                $consulta->bindValue(":color", $this->color, PDO::PARAM_STR);
                $consulta->bindValue(":marca", $this->marca, PDO::PARAM_STR);
                $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
                $consulta->bindValue(":modelo", $this->modelo, PDO::PARAM_STR);

                $consulta->execute();

                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
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

        $tabla = Auto::TraerAutos();
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

    public static function TraerAutos()
    {
        try {
            $AccesoDatos = AccesoDatos::TraerAccesoDatos();
            $consulta = $AccesoDatos->RetornarConsulta("SELECT * FROM autos");
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

    public static function Modificacion(Request $request,Response $response, $args)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Error al modificar auto";
        $retorno->status = 418;

        $params = $request->getHeader('obj_json')[0];
        $json_auto = json_decode($params);

        if(isset($json_auto))
        {
            $auto = Auto::construirAuto($json_auto->id, $json_auto->color, $json_auto->marca, $json_auto->precio, $json_auto->modelo);
            if($auto->ModificarAuto())
            {
                $retorno->exito = true;
                $retorno->mensaje = "auto modificado";
                $retorno->status = 200;
            }
        }

        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    public static function Baja(Request $request,Response $response, $args)
    {   
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Error al eliminar auto";
        $retorno->status = 418;

        $id = $request->getHeader('id')[0];

        if(isset($id))
        {
            if(Auto::BorrarAuto($id))
            {
                $retorno->exito = true;
                $retorno->mensaje = "auto eliminado";
                $retorno->status = 200;
            }
        }  

        $newResponse = $response->withStatus($retorno->status);
        $newResponse->getBody()->write(json_encode($retorno));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function BorrarAuto($id)
    {
        $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                 $consulta = $AccesoDatos->RetornarConsulta("DELETE FROM autos WHERE id = :id");

                $consulta->bindValue(":id", $id, PDO::PARAM_INT);

                $consulta->execute();

                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
    }
    public function ModificarAuto()
    {
        $ret = false;
            try {
                $AccesoDatos = AccesoDatos::TraerAccesoDatos();
                $consulta = $AccesoDatos->RetornarConsulta("UPDATE autos SET color = :color, marca = :marca, precio = :precio, modelo = :modelo WHERE id = :id");

                $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
                $consulta->bindValue(":color", $this->color, PDO::PARAM_STR);
                $consulta->bindValue(":marca", $this->marca, PDO::PARAM_STR);
                $consulta->bindValue(":precio", $this->precio, PDO::PARAM_INT);
                $consulta->bindValue(":modelo", $this->modelo, PDO::PARAM_STR);

                $consulta->execute();

                $ret = true;
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
            return $ret;
    }

}
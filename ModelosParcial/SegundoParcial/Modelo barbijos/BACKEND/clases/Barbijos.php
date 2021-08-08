<?php

require_once 'AccesoDatos.php';
require_once 'AutentificadorJWT.php';


class Barbijos
{
    public static function Alta($request, $response, $args)
    { 
        $datos = $request->getParsedBody();

        $jsonDatos = $datos['barbijo'];
        $barbijo = json_decode($jsonDatos);
        
        $color = $barbijo->color;
        $tipo = $barbijo->tipo;
        $precio = $barbijo->precio;
        

        $json = new stdClass();  
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into  
        barbijos (color, tipo, precio)
        values(:color, :tipo, :precio)");

        $consulta->bindValue(':color',$color);
        $consulta->bindValue(':tipo', $tipo);
        $consulta->bindValue(':precio', $precio);
        

        if($consulta->execute())
        {
            $json->exito=true; 
            $json->mensaje="OK"; 

            $newResponse = $response->withJson($json, 200);
        }
        else
        {
            $json->exito=false; 
            $json->mensaje="Error."; 

            $newResponse = $response->withJson($json, 418);
        }      

        return $newResponse;
    }

    public static function Listado($request, $response, $args)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM barbijos");
        $json = new stdClass();  


        if($consulta->execute()){
            $retorno=$consulta->fetchAll(PDO::FETCH_CLASS, "Barbijos");

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

        //echo $json->tabla;

        return $newResponse;
    }

    public static function Eliminar($request, $response, $args)
    {
        $jsonRespuesta = new StdClass();
        $datos = $request->getParsedBody();    
        
        $id = $datos['id_barbijo'];
        $headers = getallheaders();
        $jwt = $headers["token"];

        $user = AutentificadorJWT::DecodificarToken($jwt);
        //if(strtolower($user->perfil)=="propietario")
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM barbijos WHERE id = :idAct");

            $consulta->bindValue(':idAct', $id, PDO::PARAM_STR);  //PDO::PARAM_STR String
            $consulta->execute();
            
            if($consulta->rowCount() > 0) 
            {
                $jsonRespuesta->exito = true;
                $jsonRespuesta->mensaje = "Barbijo eliminado.";
                $newResponse = $response->withJson($jsonRespuesta, 200);
            }
            else
            {
                $jsonRespuesta->exito = false;
                $jsonRespuesta->mensaje = "Ocurrió un error al intentar eliminar el barbijo.";
                $newResponse = $response->withJson($jsonRespuesta, 418);
            }
        }
       /* else
        {
            $jsonRespuesta->exito = false;
            $jsonRespuesta->mensaje = $user->apellido." ".$user->nombre." esta tratando de borrar barbijos!";
            
            $newResponse = $response->withJson($jsonRespuesta, 418);
        }*/

        return $newResponse;
    }


    public static function Modificar($request, $response, $args)
    {
        $jsonRespuesta = new StdClass();
        $datos = $request->getParsedBody();    

        $jsonDatos = $datos['barbijo'];
        //$idBarbijo=$datos['id_barbijo'];
        $barbijo = json_decode($jsonDatos);
        $headers = getallheaders();
        $jwt = $headers["token"];

        $user = AutentificadorJWT::DecodificarToken($jwt);

        //if(strtolower($user->perfil)=="encargado")
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE barbijos SET color = :color, tipo = :tipo, precio = :precio WHERE id = :id");

            $consulta->bindValue(':color', $barbijo->color, PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $barbijo->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $barbijo->precio, PDO::PARAM_INT);
            
            $consulta->bindValue(':id', $barbijo->id, PDO::PARAM_STR);
            $consulta->execute();
            
            if($consulta->rowCount() > 0) 
            {
                $jsonRespuesta->exito = true;
                $jsonRespuesta->mensaje = "Barbijo modificado.";
                $newResponse = $response->withJson($jsonRespuesta, 200);
            }
            else
            {
                $jsonRespuesta->exito = false;
                $jsonRespuesta->mensaje = "Ocurrió un error al intentar modificar el barbijo.";
                $newResponse = $response->withJson($jsonRespuesta, 418);
            }
        }
    /* else
        {
            $jsonRespuesta->exito = false;
            $jsonRespuesta->mensaje = $user->apellido." ".$user->nombre." se quiso pasar de listo modificando un barbijo.";
            
            $newResponse = $response->withJson($jsonRespuesta, 418);
        }*/

        return $newResponse;
    }



}
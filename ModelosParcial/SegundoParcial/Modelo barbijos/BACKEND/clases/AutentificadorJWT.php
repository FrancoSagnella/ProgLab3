<?php
require_once './composer/vendor/autoload.php';
 
use Firebase\JWT\JWT;

class AutentificadorJWT
{
    private static $claveSecreta = 'tghjkfeaskl54363456';
    private static $tipoEncriptacion = ['HS256'];

    public static function CrearToken($datos)
    {
        //Expira en 30 segundos
        $expiracion = time() + 900;
        $user = array(
        "correo" => $datos->correo,
         "clave" => $datos->clave, 
         "nombre" => $datos->nombre, 
         "apellido" => $datos->apellido, 
         "perfil" => $datos->perfil, 
         "foto" => $datos->foto, 
         "exp" => $expiracion);

        //$user = array("correo" => $datos->correo, "clave" => $datos->clave, "nombre" => $datos->nombre, "apellido" => $datos->apellido, "perfil" => $datos->perfil, "foto" => $datos->foto);
        
        return JWT::encode($user, self::$claveSecreta);
    }
    
    public static function VerificarToken($token)
    {
        $rta = false;
        
        if(empty($token) || $token === "")
        {
            throw new Exception("El token está vacio!!!");
        }

        try
        {
            //DECODIFICO EL TOKEN RECIBIDO
            $decodificado = JWT::decode(
                $token,
                self::$claveSecreta,
                self::$tipoEncriptacion
            );
            
        }catch(Exception $exception)
        {
            //throw new Exception("Token no válido!!! --> " . $exception->getMessage());
            return false;
        }

        $rta = true;
        
        return $rta;
    }
    
   
     public static function ObtenerPayLoad($token)
    {
        return JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        );
    }
     public static function ObtenerData($token)
    {
        return JWT::decode(
            $token,
            self::$claveSecreta,
            self::$tipoEncriptacion
        )->data;
    }
    

    public static function DecodificarToken($token)
    {
        $rta = false;

        if(empty($token) || $token === "")
        {
            throw new Exception("El token está vacio!!!");
        }

        try
        {
            //DECODIFICO EL TOKEN RECIBIDO
            $decodificado = JWT::decode(
                $token,
                self::$claveSecreta,
                self::$tipoEncriptacion
            );
        }
        
        catch(Exception $exception)
        {
            //throw new Exception("Token no válido!!! --> " . $exception->getMessage());
            return null;
        }
        
        return $decodificado;
    }
}
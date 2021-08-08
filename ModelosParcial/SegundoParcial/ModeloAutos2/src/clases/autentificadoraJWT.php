<?php

//puedo usra la clase jwt
use Firebase\JWT\JWT;

require_once 'usuario.php';


//En esta clase me quedan todos los metodos para, crear un JWT, validarlo, obtener sus datos
class AutentificadoraJWT{

    private static $secret_key = 'ClaveSuperSecreta@';
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function CrearJWT($usuario)
    {
        //agarro la fecha
        $time = time();
        self::$aud = self::Aud();

        $token = array(
            //guardo el aud, que tiene datos para validar al usuario al host, etc
            'aud' => self::$aud,
            //le establezco fecha de creacion
        	'iat'=>$time,
            //le establezco fecha de caducidad (30 segundos)
            'exp' => $time + 300,
            //le establezco todos los datos del usuario
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'apellido' => $usuario->apellido,
            'correo' => $usuario->correo,
            'clave' => $usuario->clave,
            'perfil' => $usuario->perfil,
            'foto' => $usuario->foto,
        );

        //con este metodo, le paso la clave, los datos, y el algoritmo (uso el que viene por default, por eso no le paso nada)
        //y me devuelve un JWT string
        return JWT::encode($token, self::$secret_key);
    }

    public static function ObtenerPayLoad($token)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->payload = null;
        //el mensaje lo dejo vacio, se va a llenar con algo solo si hay un error
        $retorno->mensaje = '';
        $retorno->status = 403;

        //dentro de un try catch siempre
        try {
            //uso el metodo decode de la calse JWT, le paso como parametros el token, la clave y el tipo de encriptado (que los defini como parametros de la clase)
            //eso lo guardo en el parametro payLoad de mi retorno
            $retorno->payload = JWT::decode(
                                            $token,
                                            self::$secret_key,
                                            self::$encrypt
                                        );
            //cambio el exito a true
            $retorno->exito = TRUE;
            $retorno->status = 200;

        } catch (Exception $e) { 
            //Si llegara a haber algun error leyendo el token, entro aca y escribo el mensaje de error
            //que me salto
            //si pasa esto, el exito y el payload van a quedar en false y null, y el mensaje va a informar el error
            $retorno->mensaje = $e->getMessage();
        }

        return $retorno;
    }

    //va a devolver true o false si el jwt es valido o no + un mensaje
    public static function ValidarJWT($token)
    {
        $retorno = new stdClass();
        $retorno->exito = false;
        $retorno->mensaje = "Token invalido";
        $retorno->status = 403;

        //dentro de un try catch, porque si hay un error, por ejemplo, no se puede decodear el jwt, sale una excepcion
        try 
        {
            //valido si tiene algun contenido o esta vacio
            if( ! isset($token))
            {
                $retorno->mensaje = "Token vacío";
            }
            else
            {   //obtengo su payload
                $decode = JWT::decode(
                    $token,
                    self::$secret_key,
                    self::$encrypt
                );

                //valido si el aud que tiene el jwt es igual al de mi clase
                //si no es lanzo una excepcion
                if($decode->aud !== self::Aud())
                {
                    throw new Exception("Usuario inválido");
                }
                //si es igual devuelvo true, el token ya es valido
                //(existe y el aud esta bien)
                else
                {
                    $retorno->exito = true;
                    $retorno->mensaje = "Token ok";
                    $retorno->status = 200;
                } 
            }          
        } 
        catch (Exception $e) 
        {
            //si se lanzo una expecion devuelvo un mensaje de error que me haya tirado, el exito va a estar en false
            $retorno->mensaje = "Token inválido - " . $e->getMessage();
        }
    
        return $retorno;
    }

    //Esto del aud es basicamente una forma para validar los uduarios
    //guardando la ip del usuario, el nombre del host, algunos que otros datos tanto del usuario como del server
    private static function Aud() : string
    {
        $aud = new stdClass();
        $aud->ip_visitante = "";

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud->ip_visitante = $_SERVER['HTTP_CLIENT_IP'];
        } 
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud->ip_visitante = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud->ip_visitante = $_SERVER['REMOTE_ADDR'];//La dirección IP desde la cual está viendo la página actual el usuario.
        }
        
        $aud->user_agent = @$_SERVER['HTTP_USER_AGENT'];
        $aud->host_name = gethostname();
        
        return json_encode($aud);//sha1($aud);
    }
}
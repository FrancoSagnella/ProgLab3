<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();


//*********************************************************************************************//
//EJERCICIO 1:
//AGREGAR EL GRUPO /CREDENCIALES CON LOS VERBOS GET Y POST (MOSTRAR QUE VERBO ES)
//AL GRUPO, AGREGARLE UN MW QUE, DE ACUERDO EL VERBO, VERIFIQUE CREDENCIALES O NO. 
//GET -> NO VERIFICA (INFORMARLO). ACCEDE AL VERBO.
//POST-> VERIFICA; SE ENVIA: NOMBRE Y PERFIL.
//*-SI EL PERFIL ES 'ADMINISTRADOR', MUESTRA EL NOMBRE Y ACCEDE AL VERBO.
//*-SI NO, MUESTRA MENSAJE DE ERROR. NO ACCEDE AL VERBO.
//*********************************************************************************************//

$app->group('/credenciales', function (RouteCollectorProxy $grupo) {

  //EN LA RAIZ DEL GRUPO
  $grupo->get('/', function (Request $request, Response $response, array $args): Response {

    $response->getBody()->write("-GET- En el raíz del grupo...");
    return $response;

  });

  $grupo->post('/', function (Request $request, Response $response, array $args): Response {

    $response->getBody()->write("-POST- En el raíz del grupo...");
    return $response;

  });

})->add(function (Request $request, RequestHandler $handler) : ResponseMW {
  $antes = "entro al MW ";
  $contenidoApi = "";
  //en la variable request tengo la peticion, con su metodo, sus parametros, etc
  if($request->getMethod() === "GET")
  {
    //La variable response va a guardar lo que me devuelva el handler
    //el handler guarda la sigiente funcion a llamar, si a la estructura de 
    //funciones le sigue otro mw, llama al mw, si le sigue algun metodo de verdo, llama a eso
    //En este caso pasa directamente a llamar a algun metodo que este dentro del grupo
    //dependiendo que tenga el $request, en este caso es get
    //ese metodo va a devolver un objeto response, con algun texto escrito
    //que se va a guardar en mi variable response
    $response = $handler->handle($request);
    $antes.="No necesitaba verificar<br>";
    //recupero lo que me devolvio la api (en el cuerpo de la respuesta)
    //y lo escribo en una variable para devolver
    //esto lo hago en caso de que no se entre aca por ejemplo, poque si no hay response romperia
    //Haciendo esto me aseguro de siempre devolver un string que va a estar o vacio si 
    //no se entro nunca  una api, o con algun contenido que me haya devuelto la api
    $contenidoApi = $response->getBody();
  }
  else if($request->getMethod() === "POST"){
    //la peticion post tiene parametros en el cuerpo, con el metodo getParsedBody obtengo un array
    //asociativo de los parametros del cuerpo de la peticion
    $arrayParametros = $request->getParsedBody();

    $nombre = $arrayParametros["nombre"];
    $perfil = $arrayParametros["perfil"];

    if($perfil === "administrador"){
      //si es administrador, accedo a la api
      $response = $handler->handle($request);
      //Despues concateno el nombre qcyo hago lo que tenga que hacer
      $antes.="Hola {$nombre} <br>";
      //como antes, cuardo el contenido de la api en na variable para despues ver si la muestro
      $contenidoApi = $response->getBody();
    }
    else{
      $antes.="{$nombre} no tiene permiso, no es ADMIN";
    }
  }

  $despues = "<br> Salgo del MW";
  //Voy a crear un nuevo response, para devolver desde este mw
  $newResponse = new ResponseMW();
  //En el cuerpo de la nueva respuesta, escribo lo que tenia el cuerpo de la respuesta de la api
  //que quedo guardado en contenidoApi, o quedo vacio.
  $newResponse->getBody()->write($antes.$contenidoApi.$despues);
  //Devuelvo esta respuesta
  return $newResponse;
});

//*********************************************************************************************//
//EJERCICIO 2:
//AGREGAR EL GRUPO /JSON CON LOS VERBOS GET Y POST. RETORNA UN JSON (MENSAJE, STATUS)
//AL GRUPO, AGREGARLE UN MW QUE, DE ACUERDO EL VERBO, VERIFIQUE CREDENCIALES O NO. 
//GET -> NO VERIFICA. ACCEDE AL VERBO. RETORNA {"API => GET", 200}.
//POST-> VERIFICA; SE ENVIA (JSON): OBJ_JSON, CON NOMBRE Y PERFIL.
//*-SI EL PERFIL ES 'ADMINISTRADOR', ACCEDE AL VERBO. RETORNA {"API => POST", 200}.
//*-SI NO, MUESTRA MENSAJE DE ERROR. NO ACCEDE AL VERBO. {"ERROR. NOMBRE", 403}
//*********************************************************************************************//

$app->group('/json', function (RouteCollectorProxy $grupo) {

  $grupo->get('/', function (Request $request, Response $response, array $args): Response {

    $datos = new stdclass();

    $datos->mensaje = "API => GET";

    $newResponse = $response->withStatus(200);
  
    $newResponse->getBody()->write(json_encode($datos));

    return $newResponse->withHeader('Content-Type', 'application/json');

  });

  $grupo->post('/', function (Request $request, Response $response, array $args): Response {

    $datos = new stdclass();

    $datos->mensaje = "API => POST";

    $newResponse = $response->withStatus(200);
  
    $newResponse->getBody()->write(json_encode($datos));

    return $newResponse->withHeader('Content-Type', 'application/json');

  });
  //al grupo le agrego un middleware
        //estructura:   la peticion  ,la siguiente funcion calleable (ya sea otro middleware o el verbo)
        //                                                   retorna un objeto response
        //                                                    que puede tener codigo de status, cuerpo con texto, un objeto, etc
})->add(function (Request $request, RequestHandler $handler) : ResponseMW {

  $retorno = new stdClass();
  $retorno->mensaje = "ERROR, no habia metodo ni GET ni POST";
  $status = 403;

  if($request->getMethod() === "GET")
  {
    $APIresponse = $handler->handle($request);
    //hago json decode porque lo recibi encodeado, como cadena
    $retorno = json_decode($APIresponse->getBody());
    $status = 200;
  }
  else if($request->getMethod() === "POST")
  {
    $arrayParams = $request->getParsedBody();
    $obj_json = json_decode($arrayParams["obj_json"]);

    if($obj_json->perfil === "administrador")
    {
      $APIresponse = $handler->handle($request);
      $retorno = json_decode($APIresponse->getBody());
      $status = 200;
    }
    else{
      $retorno->mensaje = "ERROR. {$obj_json->nombre}";
    }
  }

  //seguj lo que paso, la variable tiene el status que corresponda
  //cuando instancio la respuesta le pongo ese status
  $newResponse = new ResponseMW($status);
  //encodeo el json que, o bien recibi como respuesta de la api, o arme porque no fui a la api
  $newResponse->getBody()->write(json_encode($retorno));

  //le pongo como header para que, la pagina que va a recibir la respuesta, sepa que es un json
  return $newResponse->withHeader('Content-type', 'application/json') ;
});

//*********************************************************************************************//
//EJERCICIO 3:
//AGREGAR EL GRUPO /JSON_BD CON LOS VERBOS GET Y POST (A NIVEL RAIZ). 
//GET Y POST -> TRAEN (EN FORMATO JSON) TODOS LOS USUARIO DE LA BASE DE DATOS. USUARIO->TRAERTODOS().
//AGREGAR UN MW, SOLO PARA POST, QUE VERIFIQUE AL USUARIO (CORREO Y CLAVE).
//POST-> VERIFICADORA->VERIFICARUSUARIO(); SE ENVIA(JSON): OBJ_JSON, CON CORREO Y CLAVE.
//*-SI EXISTE EL USUARIO EN LA BASE DE DATOS (VERIFICADORA::EXISTEUSUARIO($OBJ)), ACCEDE AL VERBO.
//*-SI NO, MUESTRA MENSAJE DE ERROR. NO ACCEDE AL VERBO. {"ERROR.", 403}
//*********************************************************************************************//

// require_once __DIR__ . '/../src/poo/accesodatos.php';
// require_once __DIR__ . '/../src/poo/usuario.php';
// require_once __DIR__ . '/../src/poo/verificadora.php';

// $app->group('/json_bd', function (RouteCollectorProxy $grupo) {

//   $grupo->get('/', \Usuario::class . ':TraerTodos'); 
//   //solo apost le estoy agregando un metodo, de la clase verificadora, que funciona como middleware
//   $grupo->post('/', \Usuario::class . ':TraerTodos')->add(\Verificadora::class . ":VerificarUsuario");  

// });


//*********************************************************************************************//
//EJERCICIO 4:
//AL EJERCICIO ANTERIOR:
//AGREGAR, A NIVEL DE GRUPO, UN MW QUE VERIFIQUE:
//GET-> ACCEDE AL VERBO. (NO HACE NADA NUEVO).
//POST-> VERIFICA SI FUE ENVIADO EL PARAMETRO 'OBJ_JSON'.
//*-SI NO, MUESTRA MENSAJE DE ERROR. NO ACCEDE AL VERBO. {"ERROR.", 403}
//*-SI FUE ENVIADO, VERIFICA SI EXISTEN LOS PARAMETROS 'CORREO' Y 'CLAVE'.
//*-*-SI ALGUNO NO EXISTE (O LOS DOS), MUESTRA MENSAJE DE ERROR. NO ACCEDE AL VERBO. {"ERROR.", 403}
//*-SI EXISTEN, ACCEDE AL VERBO.
//*********************************************************************************************//

require_once __DIR__ . '/../src/poo/accesodatos.php';
require_once __DIR__ . '/../src/poo/usuario.php';
require_once __DIR__ . '/../src/poo/verificadora.php';

$app->group('/json_bd', function (RouteCollectorProxy $grupo) {

  $grupo->get('/', \Usuario::class . ':TraerTodos'); 
  //solo apost le estoy agregando un metodo, de la clase verificadora, que funciona como middleware
  $grupo->post('/', \Usuario::class . ':TraerTodos')->add(\Verificadora::class . ":VerificarUsuario");  

})->add(\Verificadora::class . ":VerificarParametro");


//CORRE LA APLICACIÓN.
$app->run();
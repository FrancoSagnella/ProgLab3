<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Factory\AppFactory;
use \Slim\Routing\RouteCollectorProxy;

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

//SE TIENE QUE AGREGAR EL COMPONENTE TWIG --> composer require slim/twig-view
//SE ESTABLECE EL PATH DE LOS TEMPLATES
$twig = Twig::create('../src/views', ['cache' => false]);
//SE AGREGA EL MIDDLEWARE DE TWIG
$app->add(TwigMiddleware::create($app, $twig));

//************************************************************************************************************//

$app->get('/front-end-test', function (Request $request, Response $response, array $args) : Response {  

  $view = Twig::fromRequest($request);

  return $view->render($response, 'test.php', [
      'nombre' => "juan"
  ]);
  
});

$app->get('/front-end', function (Request $request, Response $response, array $args) : Response {  

  $view = Twig::fromRequest($request);

  return $view->render($response, 'principal.php');
  
});

$app->get('/', function (Request $request, Response $response, array $args) : Response {  

  $datos = new stdclass();

  $datos->mensaje = "API => GET";

  $newResponse = $response->withStatus(200);
  $newResponse->getBody()->write(json_encode($datos));

  return $newResponse->withHeader('Content-Type', 'application/json');
});

$app->post('/', function (Request $request, Response $response, array $args) : Response { 

  $datos = new stdclass();

  $datos->mensaje = "API => POST";

  $newResponse = $response->withStatus(200);
  $newResponse->getBody()->write(json_encode($datos));
  
  return $newResponse->withHeader('Content-Type', 'application/json');
});

$app->put('/', function (Request $request, Response $response, array $args) : Response {  

  $datos = new stdclass();

  $datos->mensaje = "API => PUT";

  $newResponse = $response->withStatus(200);
  $newResponse->getBody()->write(json_encode($datos));
  
  return $newResponse->withHeader('Content-Type', 'application/json');
});

$app->delete('/', function (Request $request, Response $response, array $args) : Response {  

  $datos = new stdclass();

  $datos->mensaje = "API => DELETE";

  $newResponse = $response->withStatus(200);
  $newResponse->getBody()->write(json_encode($datos));
  
  return $newResponse->withHeader('Content-Type', 'application/json');
});

//************************************************************************************************************//
// POO
//************************************************************************************************************//
require_once __DIR__ . "/../src/poo/ejemploJWT.php";

$app->post('/jwt/poo/crear[/]', \EjemploJWT::class . ':Crear');

$app->post('/jwt/poo/verificar[/]', \EjemploJWT::class . ':Verificar');

$app->post('/jwt/poo/obtener_payload[/]', \EjemploJWT::class . ':ObtenerPayLoad');

$app->post('/jwt/poo/obtener_datos[/]', \EjemploJWT::class . ':ObtenerDatos');

$app->get('/jwt/poo/verificar[/]', \EjemploJWT::class . ':VerificarPorHeader');

$app->get('/listado/autos[/]', \EjemploJWT::class . ':ObtenerAutosJson');

$app->get('/listado/autos/jwt[/]', \EjemploJWT::class . ':ObtenerAutosJson')->add(\EjemploJWT::class . ':VerificarToken');

//************************************************************************************************************//
//************************************************************************************************************//


require_once __DIR__ . "/../src/poo/verificadora.php";
require_once __DIR__ . "/../src/poo/cd.php";


$app->post('/login[/]', \Verificadora::class . ':VerificarUsuario')->add(\Verificadora::class . ':ValidarParametrosUsuario');

$app->get('/login/test', \Verificadora::class . ':ObtenerDataJWT')->add(\Verificadora::class . ':ChequearJWT');


$app->group('/json_bd', function (RouteCollectorProxy $grupo) {

  $grupo->get('/', \cd::class . ':TraerTodos');

  $grupo->get('/{id}', \cd::class . ':TraerUno');

  $grupo->post('/', \cd::class . ':Agregar')->add(\Verificadora::class . ':ValidarParametrosCDAgregar');

  $grupo->put('/', \cd::class . ':Modificar')->add(\Verificadora::class . ':ValidarParametrosCDModificar');

  $grupo->delete('/', \cd::class . ':Eliminar')->add(\Verificadora::class . ':ValidarParametrosCDBorrar');
     
})->add(\Verificadora::class . ':ChequearJWT');


//CORRE LA APLICACIÓN.
$app->run();
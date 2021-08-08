<?php
//agrego esta clase para poder crear grupos
use \Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//puedo usar la clase appfactory
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;


require __DIR__ . '/../vendor/autoload.php';
require_once "../src/poo/usuario.php";
require_once "../src/poo/auto.php";


//creo la api
$app = AppFactory::create();
//$app->setBasePath('../');


$twig = Twig::create('../src/views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/front-end-login', function (Request $request, Response $response, array $args) : Response {  

    $view = Twig::fromRequest($request);
  
    return $view->render($response, 'login.html');
    
  });

$app->get('/front-end-registro', function (Request $request, Response $response, array $args) : Response {  

  $view = Twig::fromRequest($request);
  
  return $view->render($response, 'registro.html');
    
});

$app->get('/front-end-principal', function (Request $request, Response $response, array $args) : Response {  

  $view = Twig::fromRequest($request);
  
  return $view->render($response, 'principal.php');
    
});


$app->post('/usuarios[/]', \Usuario::class . '::Agregar')->add(\MW::class . '::VerificarCorreoBD')->add(\MW::class . '::VerificarCamposVacios')->add(\MW::class . ':VerificarCamposSeteados');


$app->get('/login[/]', \Usuario::class . '::VerificarJWT');
$app->post('/login[/]', \Usuario::class . '::CrearJWT')->add(\MW::class . ':VerificarCorreoClaveBD')->add(\MW::class . '::VerificarCamposVacios')->add(\MW::class . ':VerificarCamposSeteados');


$app->get('/autos/[{id_auto}]', \Auto::class . '::TraerTodos')/*->add(\MW::class . ':TraerAutosEncargado')->add(\MW::class . ':TraerAutosEmpleados')->add(\MW::class . '::TraerAutosPropietario')*/->add(\MW::class . ':VerificarTokenMW');


$app->get('/[{apellido}]', \Usuario::class . '::Lista');/*->add(\MW::class . ':TraerUsuariosEncargado')->add(\MW::class . ':TraerUsuariosEmpleados')->add(\MW::class . '::TraerUsuariosPropietario')*///->add(\MW::class . ':VerificarTokenMW');
$app->post('/', \Auto::class . '::Agregar')->add(\MW::class . ':VerificarParametrosAuto');
$app->put('/', \Auto::class . '::Modificar');//->add(\MW::class . ':VerificarEncargado')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarTokenMW');
$app->delete('/', \Auto::class . '::Eliminar');//->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarTokenMW');



$app->run();
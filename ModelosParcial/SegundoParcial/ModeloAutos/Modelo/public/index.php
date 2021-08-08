<?php
//agrego esta clase para poder crear grupos
use \Slim\Routing\RouteCollectorProxy;

//puedo usar la clase appfactory
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';
require_once "../src/clases/usuario.php";
require_once "../src/clases/auto.php";


//creo la api
$app = AppFactory::create();

$app->get('/', \Usuario::class . '::Listado');
$app->post('/', \Auto::class . '::Alta');
$app->delete('/', \Auto::class . '::Baja')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarTokenMW');
$app->put('/', \Auto::class . '::Modificacion')->add(\MW::class . ':VerificarEncargado')->add(\MW::class . ':VerificarTokenMW');

$app->group('/usuarios', function (RouteCollectorProxy $grupo){
    $grupo->post('[/]', \Usuario::class . '::Alta');
});

$app->group('/autos', function (RouteCollectorProxy $grupo){
    $grupo->get('[/]', \Auto::class . '::Listado');
});

$app->group('/login', function (RouteCollectorProxy $grupo){
    $grupo->post('[/]', \Usuario::class . '::CrearJWT');
    $grupo->get('[/]', \Usuario::class . '::VerificarJWT');
});

$app->run();
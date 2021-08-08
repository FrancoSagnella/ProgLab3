<?php
//agrego esta clase para poder crear grupos
use \Slim\Routing\RouteCollectorProxy;

//puedo usar la caclse appfactory
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';
require_once "../src/poo/cd.php";
require_once "../src/poo/verificadora.php";


//creo la api
$app = AppFactory::create();

$app->post('/login[/]', \Verificadora::class . ':VerificarUsuario')->add(\Verificadora::class . ':ValidarParametrosUsuario');
$app->get('/login/test', \Verificadora::class . ':ObtenerDataJWT')->add(\Verificadora::class . ':ChequearJWT');

$app->group('/json_bd', function (RouteCollectorProxy $grupo){

    $grupo->get('/', \Cd::class . ':TraerTodos');
    $grupo->get('/{id}', \Cd::class . ':TraerUno');
    $grupo->post('/', \Cd::class . ':Agregar');//->add(\Verificadora::class . ':ValidarParametrosCdAgregar');
    $grupo->put('/', \Cd::class . ':Modificar');//->add(\Verificadora::class . ':ValidarParametrosCdModificar');
    $grupo->delete('/', \Cd::class . ':Eliminar');//->add(\Verificadora::class . ':ValidarParametrosCdEliminar');

});//->add(\Verificadora::class . ':ChequearJWT');

//corro la api
$app->run();
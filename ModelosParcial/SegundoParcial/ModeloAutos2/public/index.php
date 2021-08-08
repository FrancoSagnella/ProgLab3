<?php
//agrego esta clase para poder crear grupos
use \Slim\Routing\RouteCollectorProxy;

//puedo usar la clase appfactory
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';
require_once "../src/clases/usuario.php";
require_once "../src/clases/auto.php";
require_once "../src/clases/pdfListado.php";


//creo la api
$app = AppFactory::create();

$app->group('/usuarios', function (RouteCollectorProxy $grupo){

    $grupo->get('[/]', \Usuario::class . '::Lista');
    $grupo->post('[/]', \Usuario::class . '::Agregar')->add(\MW::class . '::VerificarCorreoBD')->add(\MW::class . '::VerificarCamposVacios')->add(\MW::class . ':VerificarCamposSeteados');

});

$app->group('/login', function (RouteCollectorProxy $grupo){

    $grupo->get('[/]', \Usuario::class . '::VerificarJWT');
    $grupo->post('[/]', \Usuario::class . '::CrearJWT')->add(\MW::class . ':VerificarCorreoClaveBD')->add(\MW::class . '::VerificarCamposVacios')->add(\MW::class . ':VerificarCamposSeteados');

});

$app->group('/autos', function (RouteCollectorProxy $grupo){

    $grupo->get('[/]', \Auto::class . '::TraerTodos')->add(\MW::class . ':TraerAutosEncargado')->add(\MW::class . ':TraerAutosEmpleados');//->add(\MW::class . '::TraerAutosPropietario');
    $grupo->get('/{id}', \Auto::class . '::TraerUno');
    $grupo->post('[/]', \Auto::class . '::Agregar')->add(\MW::class . ':VerificarParametrosAuto');
    $grupo->put('[/]', \Auto::class . '::Modificar')->add(\MW::class . ':VerificarEncargado')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarTokenMW');
    $grupo->delete('[/]', \Auto::class . '::Eliminar')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarTokenMW');

});

$app->group('/pdf', function (RouteCollectorProxy $grupo){

    $grupo->get('/{tipo_pdf}', \pdf::class . '::Listado');//Le podria agregar algun MW para validar el token y validar los parametros del tipo de pdf
});

$app->run();
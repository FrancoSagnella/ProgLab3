<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/Barbijos.php';
require_once './clases/Usuarios.php';
require_once './clases/MW.php';
require_once './clases/pdfListado.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

////USAR APRA AUTENTICACION ULTIMA LINEA           })->add($mdwAuth);

$app = new \Slim\App(["settings" => $config]);
/*
$app->group('/', function () 
{    
    $this->get('Listado', \Usuarios::class . '::Listado');
    $this->post('Alta', \Auto::class . '::Alta')->add(\MW::class . ':MdwVerificarPrecioColor');
    $this->delete('Eliminar', \Auto::class . '::Eliminar')->add(\MW::class . '::MdwVerificarPropietario')->add(\MW::class . ':VerificarToken');
    $this->put('Modificar', \Auto::class . '::Modificar')->add(\MW::class . ':MdwVerificarEncargado')->add(\MW::class . ':VerificarToken');
});
*/

$app->get('[/]', \Usuarios::class . '::Listado');
$app->post('[/]', \Barbijos::class . '::Alta');//->add(\MW::class . ':MdwVerificarPrecioColor');

$app->delete('[/]', \Barbijos::class . '::Eliminar');/*->add(\MW::class . '::MdwVerificarPropietario')->add(\MW::class . ':VerificarToken');*/
$app->put('[/]', \Barbijos::class . '::Modificar');/*->add(\MW::class . ':MdwVerificarEncargado')->add(\MW::class . ':VerificarToken');*/

$app->group('/usuarios', function () 
{    
    $this->post('[/]',\Usuarios::class . '::Alta')->add(\MW::class . '::MdwVerificarMailBaseDeDatos')->add(\MW::class . '::MdwLoginVacio')->add(\MW::class . ':MdwLoginSeteado');
});

$app->group('/barbijos', function () 
{    
    $this->get('[/]', \Barbijos::class . '::Listado');
});

$app->group('/login', function () 
{    
    $this->post('[/]', \Usuarios::class . '::CrearJWT')->add(\MW::class . ':MdwVerificarBaseDeDatos')->add(\MW::class . '::MdwLoginVacio')->add(\MW::class . ':MdwLoginSeteado');
    $this->get('[/]', \Usuarios::class . '::VerificarJWT');
});

$app->group('/pdf', function () 
{    
    $this->get('/{tipo_pdf}', \pdf::class . '::Listado');
});
  
$app->run();

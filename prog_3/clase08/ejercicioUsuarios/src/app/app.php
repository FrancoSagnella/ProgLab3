<?php

//agrego referencia al autoload asi puedo usar las cosas de slim
require_once __DIR__ . '/../../vendor/autoload.php';
//agrego la referencia al archivo donde esta mi clase, asi puedo llamar a sus metodos
require_once __DIR__ . "/../clases/usuarios.php";

//Tengo que agregar este use asi puedo usar el tipo RouteCollectorProxy para la funcion group
//y el AppFactory
use \Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;

//Creo un objeto tipo appfactory, que es el que me va a dejar gestionar la api
$app = AppFactory::create();

//Creo un grupo donde voy a poner todas las funciones del abm
$app->group('/usuario', function (RouteCollectorProxy $grupo) {   

    $grupo->get('/', Usuario::class . ':TraerTodos');
    $grupo->get('/{id}', \Usuario::class . ':TraerUno');
    $grupo->post('/', \Usuario::class . ':AgregarUno');
    $grupo->put('/{json}', \Usuario::class . ':ModificarUno');
    $grupo->delete('/{id}', \Usuario::class . ':BorrarUno');
    $grupo->post('/login/', \Usuario::class . ':Login');
});

//CORRE LA APLICACIÓN.
$app->run();

//La idea es que yo le voy a hacer peticiones a esta pagina, y dependiendo el metodo y la ruta a la que haga la peticion,
//va a entrar al group y a las funciones que correspondan, esos metodos van a llamar a las funciones que
//le pase como parametro que son las que van a llevar a cabo el ABM, basicamente cada una de esas funciones hace
//lo que antes hacia con difernetes paginas, pero ahora siempre hago las peticiones a la misma

//Voy a querer usar: get para traer datos, post para insertar datos, put para modificar datos y delete para eliminar datos
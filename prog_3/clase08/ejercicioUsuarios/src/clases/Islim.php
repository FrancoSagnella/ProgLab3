<?php
//Tengo que agregar estos uses, asi puedo usar los tipos Response y Request
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface Islim{
    function TraerTodos(Request $request, Response $response, array $args) : Response;
    function TraerUno(Request $request, Response $response, array $args) : Response;
    function AgregarUno(Request $request, Response $response, array $args) : Response;
    function ModificarUno(Request $request, Response $response, array $args) : Response;
    function BorrarUno(Request $request, Response $response, array $args) : Response;
}
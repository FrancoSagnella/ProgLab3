<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


interface ICRUD{

    function TraerTodos(Request $request, Response $response, array $args) : Response;
    function TraerUno(Request $request, Response $response, array $args) : Response;
    function Agregar(Request $request, Response $response, array $args) : Response;
    function Modificar(Request $request, Response $response, array $args) : Response;
    function Eliminar(Request $request, Response $response, array $args) : Response;
}
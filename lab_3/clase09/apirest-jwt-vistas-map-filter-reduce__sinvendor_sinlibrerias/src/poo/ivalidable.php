<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;


interface IValidable{

    function ValidarParametrosUsuario(Request $request, RequestHandler $handler) : ResponseMW;
    function ValidarParametrosCDModificar(Request $request, RequestHandler $handler) : ResponseMW;
    function ValidarParametrosCDBorrar(Request $request, RequestHandler $handler) : ResponseMW;
}
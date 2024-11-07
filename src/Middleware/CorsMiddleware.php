<?php
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


class CorsMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Pasar la solicitud al siguiente middleware o controlador
        $response = $handler->handle($request);

        // Modificar la respuesta antes de devolverla
        return $response->withHeader('App-Token', '123');
    }
}

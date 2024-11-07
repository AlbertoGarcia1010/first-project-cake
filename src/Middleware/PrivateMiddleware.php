<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Cake\Http\Exception\UnauthorizedException;
use cake\log\Log;

class PrivateMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Acceder a la cabecera personalizada
        $appTokenHeader = $request->getHeaderLine('App-Token');

        $appToken = env('APP_TOKEN');
        if ((empty($appTokenHeader) || $appTokenHeader !== $appToken) && $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            // Lanzar una excepción si la cabecera no es válida
            throw new UnauthorizedException('Unauthorized Request Exception');
        }
        // Continuar al siguiente middleware/controlador
        return $handler->handle($request);
    }

}

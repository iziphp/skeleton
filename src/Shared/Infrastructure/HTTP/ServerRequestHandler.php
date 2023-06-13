<?php

namespace Shared\Infrastructure\HTTP;

use PhpStandard\Http\Server\DispatcherInterface;
use PhpStandard\HttpServerHandler\HttpServerHandler;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

/** @package Shared\Infrastructure\Http */
class ServerRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private DispatcherInterface $dispatcher
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $route = $this->dispatcher->dispatch($request);

        foreach ($route->getParams() as $param => $value) {
            $request = $request->withAttribute($param, $value);
        }

        $handler = new HttpServerHandler(
            $route->getRequestHandler(),
            ...$route->getMiddlewares()
        );

        return $handler->handle($request);
    }
}

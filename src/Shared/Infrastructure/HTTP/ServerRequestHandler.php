<?php

namespace Shared\Infrastructure\HTTP;

use Easy\Http\Server\DispatcherInterface;
use Easy\HttpServerHandler\HttpServerHandler;
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

        foreach ($route->getParams() as $param) {
            $request = $request->withAttribute(
                $param->getKey(),
                $param->getValue()
            );
        }

        $handler = new HttpServerHandler(
            $route->getRequestHandler(),
            ...$route->getMiddlewares()
        );

        return $handler->handle($request);
    }
}

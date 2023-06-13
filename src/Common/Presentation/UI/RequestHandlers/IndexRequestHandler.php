<?php

namespace Common\Presentation\UI\RequestHandlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shared\Presentation\HTTP\Response\JsonResponse;

/** @package Shared\UI\RequestHandlers */
class IndexRequestHandler implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request 
     * @return ResponseInterface 
     */
    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface {
        return new JsonResponse([
            'message' => 'Hello World!'
        ]);
    }
}

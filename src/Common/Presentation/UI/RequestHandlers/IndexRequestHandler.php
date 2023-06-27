<?php

namespace Common\Presentation\UI\RequestHandlers;

use Easy\Http\Message\RequestMethod;
use Easy\Router\Attributes\Route;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shared\Presentation\HTTP\Response\JsonResponse;

/** @package Common\Presentation\UI\RequestHandlers */
#[Route(path: '/', method: RequestMethod::GET)]
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

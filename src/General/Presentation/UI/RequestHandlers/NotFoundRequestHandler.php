<?php

namespace General\Presentation\UI\RequestHandlers;

use Easy\Http\Message\RequestMethod;
use Easy\Router\Attributes\Route;
use Easy\Router\Priority;
use Laminas\Diactoros\Exception\InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shared\Presentation\HTTP\Response\Response;

/** @package Common\Presentation\UI\RequestHandlers */
#[Route(path: '*', method: RequestMethod::GET, priority: Priority::LOW)]
class NotFoundRequestHandler implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request 
     * @return ResponseInterface 
     * @throws InvalidArgumentException 
     */
    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface {
        return (new Response())
            ->withStatus(404);
    }
}

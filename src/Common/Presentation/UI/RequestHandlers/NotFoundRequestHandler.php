<?php

namespace Common\Presentation\UI\RequestHandlers;

use Laminas\Diactoros\Exception\InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shared\Presentation\HTTP\Response\Response;

/** @package Shared\UI\RequestHandlers */
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

<?php

namespace Common\Presentation\UI\RequestHandlers;

use Laminas\Diactoros\Exception\InvalidArgumentException;
use PhpStandard\Http\Message\RequestMethodEnum;
use PhpStandard\Router\Attributes\Route;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shared\Presentation\HTTP\Response\Response;

/** @package Common\Presentation\UI\RequestHandlers */
#[Route(path: '*', method: RequestMethodEnum::GET, priority: Route::PRIORITY_LOW)]
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

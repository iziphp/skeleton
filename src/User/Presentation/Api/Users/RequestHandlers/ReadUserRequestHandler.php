<?php

declare(strict_types=1);

namespace User\Presentation\Api\Users\RequestHandlers;

use Easy\Http\Message\RequestMethod;
use Easy\Router\Attributes\Route;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shared\Infrastructure\CommandBus\Dispatcher;
use Shared\Infrastructure\CommandBus\Exception\NoHandlerFoundException;
use Shared\Presentation\HTTP\Response\JsonResponse;
use User\Application\Commands\ReadUserCommand;
use User\Presentation\Api\Users\Resources\UserResource;

/** @package User\Presentation\Api\Users\RequestHandlers */
#[Route(method: RequestMethod::GET, path: '/users/[s:id]')]
class ReadUserRequestHandler implements RequestHandlerInterface
{
    /**
     * @param Dispatcher $dispatcher 
     * @return void 
     */
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    /**
     * @param ServerRequestInterface $request 
     * @return ResponseInterface 
     * @throws NoHandlerFoundException 
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');

        $query = new ReadUserCommand($id);
        $user = $this->dispatcher->dispatch($query);

        return new JsonResponse(new UserResource($user));
    }
}

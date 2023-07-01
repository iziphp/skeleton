<?php

namespace User\Presentation\Api\Users\RequestHandlers;

use Easy\Http\Message\RequestMethod;
use Easy\Router\Attributes\Route;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shared\Infrastructure\CommandBus\Dispatcher;
use Shared\Presentation\HTTP\Response\EmptyResponse;
use User\Application\Commands\DeleteUserCommand;

#[Route(path: '/users/[s:id]', method: RequestMethod::DELETE)]
class DeleteUserRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');

        $cmd = new DeleteUserCommand($id);
        $this->dispatcher->dispatch($cmd);

        return new EmptyResponse();
    }
}

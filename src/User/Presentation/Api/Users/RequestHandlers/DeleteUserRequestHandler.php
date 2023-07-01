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
use Shared\Presentation\HTTP\Response\EmptyResponse;
use User\Application\Commands\DeleteUserCommand;

/** @package User\Presentation\Api\Users\RequestHandlers */
#[Route(path: '/users/[s:id]', method: RequestMethod::DELETE)]
class DeleteUserRequestHandler implements RequestHandlerInterface
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

        $cmd = new DeleteUserCommand($id);
        $this->dispatcher->dispatch($cmd);

        return new EmptyResponse();
    }
}

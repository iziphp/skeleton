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
use User\Application\Commands\CreateUserCommand;
use User\Presentation\Api\Users\Resources\UserResource;

/** @package User\Presentation\Api\Users\RequestHandlers */
#[Route(path: '/users', method: RequestMethod::POST)]
class CreateUserRequestHandler implements RequestHandlerInterface
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
        $cmd = new CreateUserCommand(
            email: $request->getParsedBody()['email'],
            password: $request->getParsedBody()['password'],
            firstName: $request->getParsedBody()['first_name'],
            lastName: $request->getParsedBody()['last_name'],
            language: $request->getParsedBody()['language']
        );

        $user = $this->dispatcher->dispatch($cmd);

        return new JsonResponse(
            new UserResource($user)
        );
    }
}

<?php

namespace User\Presentation\Api\Users\RequestHandlers;

use Easy\Http\Message\RequestMethod;
use Easy\Router\Attributes\Route;
use Iterator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shared\Infrastructure\CommandBus\Dispatcher;
use Shared\Presentation\Resources\ListResource;
use Shared\Presentation\HTTP\Response\JsonResponse;
use User\Application\Commands\ListUsersCommand;
use User\Domain\Entities\UserEntity;
use User\Presentation\Api\Users\Resources\UserResource;

#[Route(path: '/users', method: RequestMethod::GET)]
class ListUsersRequestHandler implements RequestHandlerInterface
{
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $cmd = new ListUsersCommand();

        if ($sort = $request->getQueryParams()['sort'] ?? null) {
            $sort = explode(':', $sort);
            $orderBy = $sort[0];
            $dir = $sort[1] ?? 'desc';
            $cmd->setOrderBy($orderBy, $dir ?? 'desc');
        }

        if ($cursor = $request->getQueryParams()['starting_after'] ?? null) {
            $cmd->setCursor(
                $cursor,
                'starting_after'
            );
        } elseif ($cursor = $request->getQueryParams()['ending_before'] ?? null) {
            $cmd->setCursor(
                $cursor,
                'ending_before'
            );
        }

        if ($limit = $request->getQueryParams()['limit'] ?? null) {
            $cmd->setLimit($limit);
        }

        /** @var Iterator<UserEntity> $users */
        $users = $this->dispatcher->dispatch($cmd);
        $res = new ListResource();

        foreach ($users as $user) {
            $res->pushData(new UserResource($user));
        }

        return new JsonResponse($res);
    }
}
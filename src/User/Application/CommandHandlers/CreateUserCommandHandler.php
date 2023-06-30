<?php

namespace User\Application\CommandHandlers;

use User\Application\Commands\CreateUserCommand;
use User\Domain\Entities\UserEntity;
use User\Domain\Services\CreateUserService;

class CreateUserCommandHandler
{
    public function __construct(
        private CreateUserService $service
    ) {
    }

    public function handle(CreateUserCommand $cmd): UserEntity
    {
        $user = new UserEntity(
            email: $cmd->email,
            password: $cmd->password,
            firstName: $cmd->firstName,
            lastName: $cmd->lastName,
            language: $cmd->language
        );

        $this->service->createUser($user);
        return $user;
    }
}

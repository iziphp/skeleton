<?php

declare(strict_types=1);

namespace User\Application\CommandHandlers;

use User\Application\Commands\CreateUserCommand;
use User\Domain\Entities\UserEntity;
use User\Domain\Exceptions\EmailTakenException;
use User\Domain\Services\CreateUserService;

/** @package User\Application\CommandHandlers */
class CreateUserCommandHandler
{
    /**
     * @param CreateUserService $service
     * @return void
     */
    public function __construct(
        private CreateUserService $service
    ) {
    }

    /**
     * @param CreateUserCommand $cmd
     * @return UserEntity
     * @throws EmailTakenException
     */
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

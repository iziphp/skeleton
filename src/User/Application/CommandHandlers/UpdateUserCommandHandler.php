<?php

namespace User\Application\CommandHandlers;

use User\Application\Commands\UpdateUserCommand;
use User\Domain\Entities\UserEntity;
use User\Domain\Services\UpdateUserService;

class UpdateUserCommandHandler
{
    public function __construct(
        private UpdateUserService $service
    ) {
    }

    public function handle(UpdateUserCommand $cmd): UserEntity
    {
        $user = $this->service->findUserOrFail($cmd->id);

        if ($cmd->firstName) {
            $user->setFirstName($cmd->firstName);
        }

        if ($cmd->lastName) {
            $user->setLastName($cmd->lastName);
        }

        if ($cmd->language) {
            $user->setLanguage($cmd->language);
        }

        $this->service->updateUser($user);
        return $user;
    }
}

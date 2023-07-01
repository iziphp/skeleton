<?php

declare(strict_types=1);

namespace User\Application\CommandHandlers;

use User\Application\Commands\UpdateUserCommand;
use User\Domain\Entities\UserEntity;
use User\Domain\Exceptions\UserNotFoundException;
use User\Domain\Services\UpdateUserService;

/** @package User\Application\CommandHandlers */
class UpdateUserCommandHandler
{
    /**
     * @param UpdateUserService $service 
     * @return void 
     */
    public function __construct(
        private UpdateUserService $service
    ) {
    }

    /**
     * @param UpdateUserCommand $cmd 
     * @return UserEntity 
     * @throws UserNotFoundException 
     */
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

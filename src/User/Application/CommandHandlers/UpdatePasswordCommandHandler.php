<?php

namespace User\Application\CommandHandlers;

use User\Application\Commands\UpdatePasswordCommand;
use User\Domain\Entities\UserEntity;
use User\Domain\Services\UpdateUserService;

class UpdatePasswordCommandHandler
{
    public function __construct(
        private UpdateUserService $service
    ) {
    }

    public function handle(UpdatePasswordCommand $cmd): UserEntity
    {
        $user = $this->service->findUserOrFail($cmd->id);
        $user->updatePassword(
            $cmd->currentPassword,
            $cmd->newPassword
        );

        $this->service->updatePassword($user);
        return $user;
    }
}

<?php

namespace User\Application\CommandHandlers;

use User\Application\Commands\UpdateEmailCommand;
use User\Domain\Entities\UserEntity;
use User\Domain\Services\UpdateUserService;

class UpdateEmailCommandHandler
{
    public function __construct(
        private UpdateUserService $service
    ) {
    }

    public function handle(UpdateEmailCommand $cmd): UserEntity
    {
        $user = $this->service->findUserOrFail($cmd->id);
        $user->updateEmail(
            $cmd->email,
            $cmd->password
        );

        $this->service->updateEmail($user);
        return $user;
    }
}

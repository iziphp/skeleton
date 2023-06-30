<?php

namespace User\Application\CommandHandlers;

use User\Application\Commands\DeleteUserCommand;
use User\Domain\Services\DeleteUserService;

class DeleteUserCommandHandler
{
    public function __construct(
        private DeleteUserService $service
    ) {
    }

    public function handle(DeleteUserCommand $cmd): void
    {
        $user = $this->service->findUserOrFail($cmd->id);
        $this->service->deleteUser($user);
    }
}

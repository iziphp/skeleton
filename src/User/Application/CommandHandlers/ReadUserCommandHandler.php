<?php

namespace User\Application\CommandHandlers;

use User\Application\Commands\ReadUserCommand;
use User\Domain\Entities\UserEntity;
use User\Domain\Services\UserReadService;

class ReadUserCommandHandler
{
    public function __construct(
        private UserReadService $service
    ) {
    }

    public function handle(ReadUserCommand $query): UserEntity
    {
        return $this->service->findUserOrFail($query->id);
    }
}

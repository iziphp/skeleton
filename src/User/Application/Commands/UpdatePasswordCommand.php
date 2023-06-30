<?php

namespace User\Application\Commands;

use Shared\Domain\ValueObjects\Id;
use Shared\Infrastructure\CommandBus\Attributes\Handler;
use User\Application\CommandHandlers\UpdatePasswordCommandHandler;
use User\Domain\ValueObjects\Password;

#[Handler(UpdatePasswordCommandHandler::class)]
class UpdatePasswordCommand
{
    public Id $id;
    public Password $currentPassword;
    public Password $newPassword;

    public function __construct(
        int $id,
        string $currentPassword,
        string $newPassword
    ) {
        $this->id = new Id($id);
        $this->currentPassword = new Password($currentPassword);
        $this->newPassword = new Password($newPassword);
    }
}

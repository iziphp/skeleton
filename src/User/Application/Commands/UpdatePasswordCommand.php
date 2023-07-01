<?php

declare(strict_types=1);

namespace User\Application\Commands;

use Shared\Domain\ValueObjects\Id;
use Shared\Infrastructure\CommandBus\Attributes\Handler;
use User\Application\CommandHandlers\UpdatePasswordCommandHandler;
use User\Domain\ValueObjects\Password;

/** @package User\Application\Commands */
#[Handler(UpdatePasswordCommandHandler::class)]
class UpdatePasswordCommand
{
    public Id $id;
    public Password $currentPassword;
    public Password $newPassword;

    /**
     * @param string $id 
     * @param string $currentPassword 
     * @param string $newPassword 
     * @return void 
     */
    public function __construct(
        string $id,
        string $currentPassword,
        string $newPassword
    ) {
        $this->id = new Id($id);
        $this->currentPassword = new Password($currentPassword);
        $this->newPassword = new Password($newPassword);
    }
}

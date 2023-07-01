<?php

namespace User\Application\Commands;

use Shared\Domain\ValueObjects\Id;
use Shared\Infrastructure\CommandBus\Attributes\Handler;
use User\Application\CommandHandlers\UpdateEmailCommandHandler;
use User\Domain\ValueObjects\Email;
use User\Domain\ValueObjects\Password;

#[Handler(UpdateEmailCommandHandler::class)]
class UpdateEmailCommand
{
    public Id $id;
    public Email $email;
    public Password $password;

    public function __construct(
        string $id,
        string $email,
        string $password
    ) {
        $this->id = new Id($id);
        $this->email = new Email($email);
        $this->password = new Password($password);
    }
}

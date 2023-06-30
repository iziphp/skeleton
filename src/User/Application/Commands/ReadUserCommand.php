<?php

declare(strict_types=1);

namespace User\Application\Commands;

use Shared\Domain\ValueObjects\Id;
use Shared\Infrastructure\CommandBus\Attributes\Handler;
use User\Application\CommandHandlers\ReadUserCommandHandler;

#[Handler(ReadUserCommandHandler::class)]
class ReadUserCommand
{
    public Id $id;

    public function __construct(int $id)
    {
        $this->id = new Id($id);
    }
}

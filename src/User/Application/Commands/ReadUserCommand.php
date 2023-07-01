<?php

declare(strict_types=1);

declare(strict_types=1);

namespace User\Application\Commands;

use Shared\Domain\ValueObjects\Id;
use Shared\Infrastructure\CommandBus\Attributes\Handler;
use User\Application\CommandHandlers\ReadUserCommandHandler;

/** @package User\Application\Commands */
#[Handler(ReadUserCommandHandler::class)]
class ReadUserCommand
{
    public Id $id;

    /**
     * @param string $id 
     * @return void 
     */
    public function __construct(string $id)
    {
        $this->id = new Id($id);
    }
}

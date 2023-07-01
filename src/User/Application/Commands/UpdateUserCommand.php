<?php

declare(strict_types=1);

namespace User\Application\Commands;

use Shared\Domain\ValueObjects\Id;
use Shared\Infrastructure\CommandBus\Attributes\Handler;
use User\Application\CommandHandlers\UpdateUserCommandHandler;
use User\Domain\ValueObjects\FirstName;
use User\Domain\ValueObjects\Language;
use User\Domain\ValueObjects\LastName;

/** @package User\Application\Commands */
#[Handler(UpdateUserCommandHandler::class)]
class UpdateUserCommand
{
    public Id $id;
    public ?FirstName $firstName = null;
    public ?LastName $lastName = null;
    public ?Language $language = null;
    public ?Id $image = null;
    public bool $removeImage = false;

    /**
     * @param string $id 
     * @return void 
     */
    public function __construct(string $id)
    {
        $this->id = new Id($id);
    }

    /**
     * @param string $value 
     * @return UpdateUserCommand 
     */
    public function setFirstName(string $value): self
    {
        $this->firstName = new FirstName($value);
        return $this;
    }

    /**
     * @param string $value 
     * @return UpdateUserCommand 
     */
    public function setLastName(string $value): self
    {
        $this->lastName = new LastName($value);

        return $this;
    }

    /**
     * @param string $value 
     * @return UpdateUserCommand 
     */
    public function setLanguage(string $value): self
    {
        $this->language = new Language($value);

        return $this;
    }
}

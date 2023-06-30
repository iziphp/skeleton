<?php

namespace User\Application\Commands;

use Shared\Infrastructure\CommandBus\Attributes\Handler;
use User\Application\CommandHandlers\CreateUserCommandHandler;
use User\Domain\ValueObjects\Email;
use User\Domain\ValueObjects\FirstName;
use User\Domain\ValueObjects\Language;
use User\Domain\ValueObjects\LastName;
use User\Domain\ValueObjects\Password;

#[Handler(CreateUserCommandHandler::class)]
class CreateUserCommand
{
    public Email $email;
    public Password $password;
    public FirstName $firstName;
    public LastName $lastName;
    public Language $language;

    public function __construct(
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $language
    ) {
        $this->email = new Email($email);
        $this->password = new Password($password);
        $this->firstName = new FirstName($firstName);
        $this->lastName = new LastName($lastName);
        $this->language = new Language($language);
    }
}

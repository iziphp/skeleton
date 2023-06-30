<?php

namespace User\Domain\Exceptions;

use Exception;
use Throwable;
use User\Domain\ValueObjects\Email;

class EmailTakenException extends Exception
{
    public function __construct(
        private readonly Email $email,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                "Email %s is already taken!",
                $email->value
            ),
            $code,
            $previous
        );
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}

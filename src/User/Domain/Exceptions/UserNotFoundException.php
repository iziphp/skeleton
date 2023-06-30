<?php

namespace User\Domain\Exceptions;

use Exception;
use Shared\Domain\ValueObjects\Id;
use Throwable;

class UserNotFoundException extends Exception
{
    public function __construct(
        private readonly Id $id,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                "User with id <%s> doesn't exists!",
                $id->getValue()
            ),
            $code,
            $previous
        );
    }

    public function getId(): Id
    {
        return $this->id;
    }
}

<?php

declare(strict_types=1);

namespace User\Domain\Exceptions;

use Exception;
use Shared\Domain\ValueObjects\Id;
use Throwable;

/** @package User\Domain\Exceptions */
class UserNotFoundException extends Exception
{
    /**
     * @param Id $id 
     * @param int $code 
     * @param null|Throwable $previous 
     * @return void 
     */
    public function __construct(
        private readonly Id $id,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                "User with id <%s> doesn't exists!",
                $id->value
            ),
            $code,
            $previous
        );
    }

    /** @return Id  */
    public function getId(): Id
    {
        return $this->id;
    }
}

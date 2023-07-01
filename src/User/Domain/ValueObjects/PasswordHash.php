<?php

declare(strict_types=1);

namespace User\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/** @package User\Domain\ValueObjects */
#[ORM\Embeddable]
class PasswordHash
{
    #[ORM\Column(type: "string", name: "password_hash")]
    public readonly string $value;

    /**
     * @param string $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        $this->ensureValueIsValid($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return void
     * @throws InvalidArgumentException
     */
    private function ensureValueIsValid(string $value)
    {
        if (mb_strlen($value) > 150) {
            throw new InvalidArgumentException(sprintf(
                '<%s> does not allow the value <%s>. Maximum 150 characters allowed.',
                static::class,
                $value
            ));
        }
    }
}

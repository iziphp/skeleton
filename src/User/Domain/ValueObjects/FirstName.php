<?php

namespace User\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

#[ORM\Embeddable]
class FirstName
{
    #[ORM\Column(type: "string", name: "first_name")]
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
        if (mb_strlen($value) > 50) {
            throw new InvalidArgumentException(sprintf(
                '<%s> does not allow the value <%s>. Maximum <%s> characters allowed.',
                static::class,
                $value,
                50
            ));
        }
    }
}

<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/** @package Shared\Domain\ValueObjects */
#[ORM\Embeddable]
class Email
{
    #[ORM\Column(type: "string", name: "email")]
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
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf(
                '<%s> does not allow the value <%s>.',
                static::class,
                $value
            ));
        }
    }
}
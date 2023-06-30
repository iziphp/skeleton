<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/** @package Shared\Domain\ValueObjects */
#[ORM\Embeddable]
class Id
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "integer", nullable: true)]
    private ?int $value;

    /**
     * @param null|int $value 
     * @return void 
     * @throws InvalidArgumentException 
     */
    public function __construct(?int $value = null)
    {
        $this->ensureValueIsValid($value);
        $this->value = $value;
    }

    /** @return null|int  */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @param null|int $value 
     * @return void 
     * @throws InvalidArgumentException 
     */
    private function ensureValueIsValid(?int $value): void
    {
        if (!is_null($value) && $value < 1) {
            throw new InvalidArgumentException(sprintf(
                '<%s> does not allow the value <%s>.',
                static::class,
                $value
            ));
        }
    }
}

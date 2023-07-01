<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidV7Generator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/** @package Shared\Domain\ValueObjects */
#[ORM\Embeddable]
class Id
{
    #[ORM\Id]
    #[ORM\Column(name: "id", type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\CustomIdGenerator(class: UuidV7Generator::class)]
    public readonly UuidInterface $value;

    public function __construct(?string $value = null)
    {
        $this->value = is_null($value)
            ? Uuid::uuid7()
            : Uuid::fromString($value);
    }
}

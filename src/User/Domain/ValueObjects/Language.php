<?php

namespace User\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

#[ORM\Embeddable]
class Language
{
    #[ORM\Column(type: "string", name: "language", length: 5)]
    public readonly string $value;

    /** @var string[] */
    protected array $langs = ['en-US'];

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
        if (!in_array($value, $this->langs)) {
            throw new InvalidArgumentException(sprintf(
                '<%s> does not allow the value <%s>.',
                static::class,
                $value
            ));
        }
    }
}
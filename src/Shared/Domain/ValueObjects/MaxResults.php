<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObjects;

use InvalidArgumentException;

/** @package Shared\Domain\ValueObjects */
class MaxResults
{
    public const MAX = 250;
    public const DEFAULT = 25;
    public readonly int $value;

    /** @return MaxResults  */
    public static function withDefaultValue(): MaxResults
    {
        return new MaxResults(self::DEFAULT);
    }

    /**
     * @param int $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function __construct(int $value)
    {
        $this->ensureValueIsValid($value);
        $this->value = $value;
    }

    /**
     * @param int $value
     * @return void
     * @throws InvalidArgumentException
     */
    private function ensureValueIsValid(int $value): void
    {
        if ($value < 1 || $value > self::MAX) {
            throw new InvalidArgumentException(sprintf(
                '<%s> does not allow the value <%s>.',
                static::class,
                $value
            ));
        }
    }
}

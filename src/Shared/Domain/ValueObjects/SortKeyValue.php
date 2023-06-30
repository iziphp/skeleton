<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObjects;

/** @package Shared\Domain\ValueObjects */
class SortKeyValue
{
    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __construct(
        public readonly string $key,
        public readonly mixed $value = null
    ) {
    }
}

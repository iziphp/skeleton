<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObjects;

/** @package Shared\Domain\ValueObjects */
class SortKeyValue
{
    /**
     * @param string $key
     * @param null|string $value
     * @return void
     */
    public function __construct(
        public readonly string $key,
        public readonly ?string $value = null
    ) {
        $this->key = $key;
        $this->value = $value;
    }
}

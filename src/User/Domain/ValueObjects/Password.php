<?php

namespace User\Domain\ValueObjects;

class Password
{
    public readonly string $value;

    /**
     * @param string $value
     * @return void
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }
}

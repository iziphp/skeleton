<?php

namespace Shared\Presentation\Resources;

use DateTimeInterface;
use JsonSerializable;

class DateTimeResource implements JsonSerializable
{
    public function __construct(
        private ?DateTimeInterface $dateTime
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return $this->dateTime ? $this->dateTime->getTimestamp() : null;
    }
}

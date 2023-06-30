<?php

namespace Shared\Presentation\Resources;

use JsonSerializable;

class ListResource implements JsonSerializable
{
    /**
     * @param array<JsonSerializable> $data
     * @return void 
     */
    public function __construct(
        private array $data = []
    ) {
    }

    public function pushData(JsonSerializable $data): void
    {
        $this->data[] = $data;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'data' => $this->data
        ];
    }
}

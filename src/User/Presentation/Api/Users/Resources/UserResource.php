<?php

namespace User\Presentation\Api\Users\Resources;

use JsonSerializable;
use Shared\Presentation\Resources\DateTimeResource;
use User\Domain\Entities\UserEntity;

class UserResource implements JsonSerializable
{
    public function __construct(
        private UserEntity $user
    ) {
    }

    /** @inheritDoc */
    public function jsonSerialize(): mixed
    {
        $u = $this->user;

        return [
            'id' => $u->getId(),
            'first_name' => $u->getFirstName(),
            'last_name' => $u->getLastName(),
            'email' => $u->getEmail(),
            'created_at' => new DateTimeResource($u->getCreatedAt()),
            'updated_at' => new DateTimeResource($u->getUpdatedAt()),
        ];
    }
}

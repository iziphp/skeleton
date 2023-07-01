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


    public function jsonSerialize(): mixed
    {
        $u = $this->user;

        return [
            'id' => $u->getId()->value,
            'first_name' => $u->getFirstName()->value,
            'last_name' => $u->getLastName()->value,
            'email' => $u->getEmail()->value,
            'created_at' => new DateTimeResource($u->getCreatedAt()),
            'updated_at' => new DateTimeResource($u->getUpdatedAt()),
        ];
    }
}

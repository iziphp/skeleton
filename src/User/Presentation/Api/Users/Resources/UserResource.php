<?php

declare(strict_types=1);

namespace User\Presentation\Api\Users\Resources;

use JsonSerializable;
use Shared\Presentation\Resources\DateTimeResource;
use User\Domain\Entities\UserEntity;

/** @package User\Presentation\Api\Users\Resources */
class UserResource implements JsonSerializable
{
    /**
     * @param UserEntity $user
     * @return void
     */
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

<?php

namespace User\Domain\Events;

use User\Domain\Entities\UserEntity;

abstract class AbstractUserEvent
{
    public function __construct(
        public readonly UserEntity $user
    ) {
    }
}

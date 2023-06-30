<?php

namespace User\Domain\Services;

use Shared\Domain\ValueObjects\Id;
use User\Domain\Entities\UserEntity;
use User\Domain\Exceptions\UserNotFoundException;
use User\Domain\Repositories\UserRepositoryInterface;

class UserReadService
{
    public function __construct(
        private UserRepositoryInterface $repo
    ) {
    }

    public function findUserOrFail(Id $id): UserEntity
    {
        $user = $this->repo->ofId($id);

        if (!$user) {
            throw new UserNotFoundException($id);
        }

        return $user;
    }
}

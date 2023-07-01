<?php

declare(strict_types=1);

namespace User\Domain\Services;

use Shared\Domain\ValueObjects\Id;
use User\Domain\Entities\UserEntity;
use User\Domain\Exceptions\UserNotFoundException;
use User\Domain\Repositories\UserRepositoryInterface;

/** @package User\Domain\Services */
class UserReadService
{
    /**
     * @param UserRepositoryInterface $repo 
     * @return void 
     */
    public function __construct(
        private UserRepositoryInterface $repo
    ) {
    }

    /**
     * @param Id $id 
     * @return UserEntity 
     * @throws UserNotFoundException 
     */
    public function findUserOrFail(Id $id): UserEntity
    {
        $user = $this->repo->ofId($id);

        if (!$user) {
            throw new UserNotFoundException($id);
        }

        return $user;
    }
}

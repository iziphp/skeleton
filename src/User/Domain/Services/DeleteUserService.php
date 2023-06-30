<?php

namespace User\Domain\Services;

use Psr\EventDispatcher\EventDispatcherInterface;
use User\Domain\Entities\UserEntity;
use User\Domain\Events\UserDeletedEvent;
use User\Domain\Repositories\UserRepositoryInterface;

class DeleteUserService extends UserReadService
{
    public function __construct(
        private UserRepositoryInterface $repo,
        private EventDispatcherInterface $dispatcher
    ) {
        parent::__construct($repo);
    }

    public function deleteUser(UserEntity $user): void
    {
        // Delete the user from the repository
        $this->repo
            ->remove($user)
            ->flush();

        // Dispatch the user deleted event
        $event = new UserDeletedEvent($user);
        $this->dispatcher->dispatch($event);
    }
}

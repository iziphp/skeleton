<?php

namespace User\Domain\Services;

use Psr\EventDispatcher\EventDispatcherInterface;
use User\Domain\Entities\UserEntity;
use User\Domain\Events\UserEmailUpdatedEvent;
use User\Domain\Events\UserPasswordUpdatedEvent;
use User\Domain\Events\UserUpdatedEvent;
use User\Domain\Exceptions\EmailTakenException;
use User\Domain\Repositories\UserRepositoryInterface;

class UpdateUserService extends UserReadService
{
    public function __construct(
        private UserRepositoryInterface $repo,
        private EventDispatcherInterface $dispatcher
    ) {
        parent::__construct($repo);
    }

    public function updateUser(UserEntity $user): void
    {
        // Call the pre update hooks
        $user->preUpdate();

        // Update the user in the repository
        $this->repo->flush();

        // Dispatch the user updated event
        $event = new UserUpdatedEvent($user);
        $this->dispatcher->dispatch($event);
    }

    public function updatePassword(UserEntity $user): void
    {
        $this->updateUser($user);

        // Dispatch the user password updated event
        $event = new UserPasswordUpdatedEvent($user);
        $this->dispatcher->dispatch($event);
    }

    public function updateEmail(UserEntity $user): void
    {
        $otherUser = $this->repo->ofEmail($user->getEmail());

        if ($otherUser && $otherUser->getId() != $user->getId()) {
            throw new EmailTakenException($user->getEmail());
        }

        $this->updateUser($user);

        // Dispatch the user email updated event
        $event = new UserEmailUpdatedEvent($user);
        $this->dispatcher->dispatch($event);
    }
}

<?php

declare(strict_types=1);

namespace User\Domain\Services;

use Psr\EventDispatcher\EventDispatcherInterface;
use User\Domain\Entities\UserEntity;
use User\Domain\Events\UserCreatedEvent;
use User\Domain\Exceptions\EmailTakenException;
use User\Domain\Repositories\UserRepositoryInterface;

/** @package User\Domain\Services */
class CreateUserService
{
    /**
     * @param UserRepositoryInterface $repo
     * @param EventDispatcherInterface $dispatcher
     * @return void
     */
    public function __construct(
        private UserRepositoryInterface $repo,
        private EventDispatcherInterface $dispatcher
    ) {
    }

    /**
     * @param UserEntity $user
     * @return void
     * @throws EmailTakenException
     */
    public function createUser(UserEntity $user): void
    {
        // Check if the email is already taken
        if ($this->repo->ofEmail($user->getEmail())) {
            // Throw an exception if the email is already taken
            throw new EmailTakenException($user->getEmail());
        }

        // Add the user to the repository
        $this->repo
            ->add($user)
            ->flush();

        // Dispatch the user created event
        $event = new UserCreatedEvent($user);
        $this->dispatcher->dispatch($event);
    }
}

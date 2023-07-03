<?php

declare(strict_types=1);

namespace User\Application\CommandHandlers;

use Shared\Domain\ValueObjects\CursorDirection;
use Traversable;
use User\Application\Commands\ListUsersCommand;
use User\Domain\Entities\UserEntity;
use User\Domain\Repositories\UserRepositoryInterface;
use User\Domain\Services\UserReadService;

/** @package User\Application\CommandHandlers */
class ListUsersCommandHandler
{
    /**
     * @param UserRepositoryInterface $repo
     * @param UserReadService $service
     * @return void
     */
    public function __construct(
        private UserRepositoryInterface $repo,
        private UserReadService $service
    ) {
    }

    /**
     * @param ListUsersCommand $cmd
     * @return Traversable<UserEntity>
     */
    public function handle(ListUsersCommand $cmd): Traversable
    {
        $user = $cmd->cursor
            ? $this->service->findUserOrFail($cmd->cursor)
            : null;

        $users = $this->repo
            ->sort($cmd->sortDirection, $cmd->sortParameter);

        if ($cmd->maxResults) {
            $users = $users->setMaxResults($cmd->maxResults);
        }

        if ($user) {
            if ($cmd->cursorDirection == CursorDirection::ENDING_BEFORE) {
                return $users = $users->endingBefore($user);
            }

            return $users->startingAfter($user);
        }

        return $users;
    }
}

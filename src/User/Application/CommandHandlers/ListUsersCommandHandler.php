<?php

declare(strict_types=1);

namespace User\Application\CommandHandlers;

use Iterator;
use Shared\Domain\ValueObjects\CursorDirection;
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
     * @return Iterator<UserEntity>
     */
    public function handle(ListUsersCommand $cmd): Iterator
    {
        $user = $cmd->cursor
            ? $this->service->findUserOrFail($cmd->cursor)
            : null;

        $users = $this->repo;

        if ($cmd->maxResults) {
            $users = $users->setMaxResults($cmd->maxResults);
        }

        if ($cmd->cursorDirection == CursorDirection::ENDING_BEFORE) {
            $users = $users->sortAndEndBefore(
                $cmd->sortDirection,
                $cmd->orderBy,
                $user
            );
        } else {
            $users = $users->sortAndStartAfter(
                $cmd->sortDirection,
                $cmd->orderBy,
                $user
            );
        }

        return $users->getIterator();
    }
}

<?php

namespace User\Application\Commands;

use Shared\Domain\ValueObjects\CursorDirection;
use Shared\Domain\ValueObjects\Id;
use Shared\Domain\ValueObjects\SliceLimit;
use Shared\Domain\ValueObjects\SortDirection;
use Shared\Infrastructure\CommandBus\Attributes\Handler;
use User\Application\CommandHandlers\ListUsersCommandHandler;
use User\Domain\ValueObjects\SortParameter;

#[Handler(ListUsersCommandHandler::class)]
class ListUsersCommand
{
    public ?SortParameter $orderBy = null;
    public SortDirection $sortDirection = SortDirection::DESC;
    public ?Id $cursor = null;
    public ?SliceLimit $limit;
    public CursorDirection $cursorDirection = CursorDirection::STARTING_AFTER;

    public function __construct()
    {
        $this->limit = new SliceLimit(SliceLimit::DEFAULT);
    }

    public function setOrderBy(string $orderBy, string $dir): void
    {
        $this->orderBy =  SortParameter::from($orderBy);
        $this->sortDirection = SortDirection::from(strtoupper($dir));
    }

    public function setCursor(int $id, string $dir = 'starting_after'): self
    {
        $this->cursor = new Id($id);
        $this->cursorDirection = CursorDirection::from($dir);

        return $this;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = new SliceLimit($limit);

        return $this;
    }
}

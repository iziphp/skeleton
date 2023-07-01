<?php

declare(strict_types=1);

namespace User\Application\Commands;

use Shared\Domain\ValueObjects\CursorDirection;
use Shared\Domain\ValueObjects\Id;
use Shared\Domain\ValueObjects\SliceLimit;
use Shared\Domain\ValueObjects\SortDirection;
use Shared\Infrastructure\CommandBus\Attributes\Handler;
use User\Application\CommandHandlers\ListUsersCommandHandler;
use User\Domain\ValueObjects\SortParameter;

/** @package User\Application\Commands */
#[Handler(ListUsersCommandHandler::class)]
class ListUsersCommand
{
    public ?SortParameter $orderBy = null;
    public SortDirection $sortDirection = SortDirection::DESC;
    public ?Id $cursor = null;
    public ?SliceLimit $limit;
    public CursorDirection $cursorDirection = CursorDirection::STARTING_AFTER;

    /** @return void  */
    public function __construct()
    {
        $this->limit = new SliceLimit(SliceLimit::DEFAULT);
    }

    /**
     * @param string $orderBy 
     * @param string $dir 
     * @return void 
     */
    public function setOrderBy(string $orderBy, string $dir): void
    {
        $this->orderBy =  SortParameter::from($orderBy);
        $this->sortDirection = SortDirection::from(strtoupper($dir));
    }

    /**
     * @param string $id 
     * @param string $dir 
     * @return ListUsersCommand 
     */
    public function setCursor(string $id, string $dir = 'starting_after'): self
    {
        $this->cursor = new Id($id);
        $this->cursorDirection = CursorDirection::from($dir);

        return $this;
    }

    /**
     * @param int $limit 
     * @return ListUsersCommand 
     */
    public function setLimit(int $limit): self
    {
        $this->limit = new SliceLimit($limit);

        return $this;
    }
}

<?php

namespace Shared\Infrastructure;

/**
 * Entity path factory to collect the directories
 * to lookup for the entities. List of those directories
 * will be used later on (Doctrine) entity manager.
 *
 * @package Modules\Shared\Infrastructure
 */
class EntityPathFactory
{
    /** @var string[] $paths */
    private array $paths = [];

    /**
     * @param string $path
     * @return EntityPathFactory
     */
    public function add(string $path): self
    {
        $this->paths[] = $path;
        return $this;
    }

    /** @return string[]  */
    public function getPaths(): array
    {
        return $this->paths;
    }
}

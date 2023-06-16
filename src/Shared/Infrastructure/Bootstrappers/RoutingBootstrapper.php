<?php

namespace Shared\Infrastructure\Bootstrappers;

use PhpStandard\Container\Attributes\Inject;
use PhpStandard\Router\Group;
use PhpStandard\Router\Map;
use PhpStandard\Router\Mapper;
use Shared\Infrastructure\BootstrapperInterface;

/** @package Shared\Infrastructure\Bootstrappers */
class RoutingBootstrapper implements BootstrapperInterface
{
    /**
     * @param Mapper $mapper 
     * @param array<int,Group|Map> $routes 
     * @return void 
     */
    public function __construct(
        private Mapper $mapper,

        #[Inject('routes')]
        private array $routes
    ) {
    }

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        foreach ($this->routes as $group) {
            $this->mapper->add($group);
        }
    }
}

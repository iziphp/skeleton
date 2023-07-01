<?php

namespace Shared\Infrastructure\Bootstrappers;

use Application;
use Easy\Container\Attributes\Inject;
use Easy\Router\Dispatcher;
use Easy\Router\Mapper\AttributeMapper;
use Psr\Cache\CacheItemPoolInterface;
use Shared\Infrastructure\BootstrapperInterface;

/** @package Shared\Infrastructure\Bootstrappers */
class RoutingBootstrapper implements BootstrapperInterface
{
    public function __construct(
        private Dispatcher $dispatcher,

        #[Inject('config.dirs.src')]
        private string $routeDir,

        #[Inject('config.enable_caching')]
        private bool $enableCaching = false,

        private ?CacheItemPoolInterface $cache = null,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        $this->dispatcher->pushMapper($this->getAttributeMapper());
    }

    private function getAttributeMapper(): AttributeMapper
    {
        $mapper = new AttributeMapper($this->cache);
        $mapper->addPath($this->routeDir);

        $this->enableCaching
            ? $mapper->enableCaching()
            : $mapper->disableCaching();

        return $mapper;
    }
}

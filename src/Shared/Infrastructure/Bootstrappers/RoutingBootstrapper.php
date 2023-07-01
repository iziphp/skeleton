<?php

declare(strict_types=1);

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
    /**
     * @param Dispatcher $dispatcher 
     * @param string $routeDir 
     * @param bool $enableCaching 
     * @param null|CacheItemPoolInterface $cache 
     * @return void 
     */
    public function __construct(
        private Dispatcher $dispatcher,

        #[Inject('config.dirs.src')]
        private string $routeDir,

        #[Inject('config.enable_caching')]
        private bool $enableCaching = false,

        private ?CacheItemPoolInterface $cache = null,
    ) {
    }

    /** @inheritDoc */
    public function bootstrap(): void
    {
        $this->dispatcher->pushMapper($this->getAttributeMapper());
    }

    /** @return AttributeMapper  */
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

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

        #[Inject('config.route_directories')]
        private array $dirs,

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
        foreach ($this->dirs as $dir) {
            $mapper->addPath($dir);
        }

        $this->enableCaching
            ? $mapper->enableCaching()
            : $mapper->disableCaching();

        return $mapper;
    }
}

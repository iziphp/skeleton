<?php

namespace Shared\Infrastructure\Bootstrappers;

use PhpStandard\Container\Attributes\Inject;
use PhpStandard\Router\Mapper\AttributeMapper;
use Shared\Infrastructure\BootstrapperInterface;

/** @package Shared\Infrastructure\Bootstrappers */
class RoutingBootstrapper implements BootstrapperInterface
{
    /**
     * @param AttributeMapper $mapper 
     * @param array<string> $dirs 
     * @param bool $enableCaching 
     * @return void 
     */
    public function __construct(
        private AttributeMapper $mapper,

        #[Inject('config.route_directories')]
        private array $dirs,

        #[Inject('config.enable_caching')]
        private bool $enableCaching = false
    ) {
    }

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        foreach ($this->dirs as $dir) {
            $this->mapper->addPath($dir);
        }

        $this->enableCaching
            ? $this->mapper->enableCaching()
            : $this->mapper->disableCaching();
    }
}

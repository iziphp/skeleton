<?php

namespace Shared\Infrastructure\Providers;

use Application;
use Easy\EventDispatcher\EventDispatcher;
use Easy\EventDispatcher\ListenerProvider;
use Easy\EventDispatcher\Mapper\EventAttributeMapper;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Shared\Infrastructure\ServiceProviderInterface;

/** @package Shared\Infrastructure\Providers */
class EventServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $container 
     * @return void 
     */
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    /** @inheritDoc */
    public function register(Application $app): void
    {
        $provider = new ListenerProvider;

        // Add event mappers here. Multiple event mappers can be added.
        $provider->addMapper(new EventAttributeMapper($this->container));

        $dispatcher = new EventDispatcher($provider);

        $app
            ->set(ListenerProviderInterface::class, $provider)
            ->set(EventDispatcherInterface::class, $dispatcher);
    }
}

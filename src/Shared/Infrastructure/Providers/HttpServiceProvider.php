<?php

namespace Shared\Infrastructure\Providers;

use Application;
use PhpStandard\Emitter\SapiEmitter;
use PhpStandard\Http\ResponseEmitter\EmitterInterface;
use PhpStandard\Http\Server\DispatcherInterface;
use PhpStandard\Router\Dispatcher;
use Shared\Infrastructure\ServiceProviderInterface;

class HttpServiceProvider implements ServiceProviderInterface
{
    /** @inheritDoc */
    public function register(Application $app): void
    {
        $app
            ->set(EmitterInterface::class, SapiEmitter::class)
            ->set(DispatcherInterface::class, Dispatcher::class);
    }
}

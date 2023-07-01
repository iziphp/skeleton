<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Providers;

use Application;
use Psr\Http\Client\ClientInterface;
use Shared\Infrastructure\ServiceProviderInterface;
use Symfony\Component\HttpClient\Psr18Client;

/** @package Shared\Infrastructure\Providers */
class HttpClientServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Application $app): void
    {
        $app->set(ClientInterface::class, Psr18Client::class);
    }
}

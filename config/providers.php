<?php

use Shared\Infrastructure\Providers\CacheServiceProvider;
use Shared\Infrastructure\Providers\EventServiceProvider;
use Shared\Infrastructure\Providers\HttpClientServiceProvider;
use Shared\Infrastructure\Providers\HttpFactoryServiceProvider;
use Shared\Infrastructure\Providers\HttpServiceProvider;

return [
    /** Define implementations for the event dispatcher interfaces (PSR-14) */
    EventServiceProvider::class,

    /** Define implementations for cache interfaces (PSR-6, PSR-16)  */
    CacheServiceProvider::class,

    /** Define implementations for HTTP factories (PSR-17) */
    HttpFactoryServiceProvider::class,

    /** Define implementation for HTTP Client [PSR-18] */
    HttpClientServiceProvider::class,
    HttpServiceProvider::class
];

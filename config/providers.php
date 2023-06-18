<?php

use Shared\Infrastructure\Providers\CacheServiceProvider;
use Shared\Infrastructure\Providers\HttpFactoryServiceProvider;
use Shared\Infrastructure\Providers\HttpServiceProvider;

return [
    /** Define implementations for cache interfaces (PSR-6, PSR-16)  */
    CacheServiceProvider::class,

    /** Define implementations for HTTP factories (PSR-17) */
    HttpFactoryServiceProvider::class,
    HttpServiceProvider::class
];

<?php

use Shared\Infrastructure\Bootstrappers\ApplicationBootstrapper;
use Shared\Infrastructure\Bootstrappers\ConsoleBootstrapper;
use Shared\Infrastructure\Bootstrappers\DoctrineBootstrapper;
use Shared\Infrastructure\Bootstrappers\RoutingBootstrapper;
use User\Infrastructure\UserModuleBootstrapper;

return [
    ApplicationBootstrapper::class,
    UserModuleBootstrapper::class,
    DoctrineBootstrapper::class,
    ConsoleBootstrapper::class,

    RoutingBootstrapper::class
];

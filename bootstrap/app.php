<?php

use Psr\Container\ContainerInterface;
use PhpStandard\Container\Container;
use Shared\Infrastructure\BootstrapperInterface;
use Shared\Infrastructure\ServiceProviderInterface;

/**
 * Bootstraps the application and the container.
 * Returns the container instance.
 * 
 * @return ContainerInterface
 */

// Make everything relative to the application root directory.
chdir(dirname(__DIR__));

require __DIR__ . '/autoload.php';

/** @var Container $container */
$container = require 'container.php';

/** @var (ServiceProviderInterface|string)[] $providers */
$providers = $container->get('providers');

/** @var (BootstrapperInterface|string)[] $providers */
$bootstrappers = $container->get('bootstrappers');

$app = new Application($container);
$app->addServiceProvider(...$providers)
    ->addBootstrapper(...$bootstrappers)
    ->boot();

return $container;

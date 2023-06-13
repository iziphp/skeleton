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

// Make everything relative to the application root path.
chdir(dirname(__DIR__));

require __DIR__ . '/autoload.php';

// Application base (root) path
$basePath = dirname(__DIR__);

/** @var (ServiceProviderInterface|string)[] $providers */
$providers = require 'config/providers.php';

/** @var (BootstrapperInterface|string)[] $providers */
$bootstrappers = require 'config/bootstrappers.php';

$container = new Container();
$container->set('basePath', $basePath);

$app = new Application($container);

$app->addServiceProvider(...$providers)
    ->addBootstrapper(...$bootstrappers)
    ->boot();

return $container;

<?php

use Adbar\Dot;
use Dotenv\Dotenv;
use PhpStandard\Container\Container;

$rootDir = dirname(__DIR__);

// Load environment variables.
$dotenv = Dotenv::createImmutable($rootDir);

// Load configuration.
$config = new Dot();
$config->set('databases', []);
$config->set('root_dir', $rootDir);
$config->set('cache_dir', $rootDir . '/var/cache');

// Setup container.
$container = new Container();
$container->set('bootstrappers', require 'config/bootstrappers.php');
$container->set('commands', require 'config/commands.php');
$container->set('middlewares', require 'config/middlewares.php');
$container->set('migrations', require 'config/migrations.php');
$container->set('providers', require 'config/providers.php');
$container->set('routes', require 'config/routes.php');

// Load config values to the container. Prefix them with 'config.'.
// Use dot notation to access nested values.
// Example: $container->get('config.databases.default');
foreach ($config->flatten(prepend: 'config.') as $abstract => $concrete) {
    $container->set($abstract, $concrete);
}

return $container;

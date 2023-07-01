<?php

use Adbar\Dot;
use Dotenv\Dotenv;
use Easy\Container\Container;

$rootDir = dirname(__DIR__);

// Load environment variables.
$dotenv = Dotenv::createImmutable($rootDir);

// Load configuration.
$config = new Dot();
$config->set('databases', []);
$config->set('dirs', [
    'root' => $rootDir,
    'cache' => $rootDir . '/var/cache',
    'log' => $rootDir . '/var/log/',
    'src' => $rootDir . '/src',
]);
$config->set('enable_caching', env('ENVIRONMENT', 'dev') == 'prod');

// Setup container.
$container = new Container();
$container->set('bootstrappers', require 'config/bootstrappers.php');
$container->set('commands', require 'config/commands.php');
$container->set('migrations', require 'config/migrations.php');
$container->set('providers', require 'config/providers.php');

// Load config values to the container. Prefix them with 'config.'.
// Use dot notation to access nested values.
// Example: $container->get('config.databases.default');

foreach ($config->flatten(prepend: 'config.') as $abstract => $concrete) {
    $container->set($abstract, $concrete);
}

return $container;

<?php

use Dotenv\Dotenv;
use Easy\Container\Container;
use Shared\Infrastructure\Config\Config;
use Shared\Infrastructure\Config\ConfigResolver;

$rootDir = dirname(__DIR__);

// Load environment variables.
$dotenv = Dotenv::createImmutable($rootDir);

// Load configuration.
$config = new Config();
$config->set('dirs', [
    'root' => $rootDir,
    'cache' => $rootDir . '/var/cache',
    'log' => $rootDir . '/var/log/',
    'src' => $rootDir . '/src',
]);
$config->set('enable_caching', env('ENVIRONMENT', 'dev') == 'prod');

// Setup container.
$container = new Container();
$container->pushResolver(new ConfigResolver($config));

$container->set('bootstrappers', require 'config/bootstrappers.php');
$container->set('commands', require 'config/commands.php');
$container->set('migrations', require 'config/migrations.php');
$container->set('providers', require 'config/providers.php');

return $container;

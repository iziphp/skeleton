<?php

use Adbar\Dot;
use PhpStandard\Container\Container;

$rootDir = dirname(__DIR__);

$config = new Dot();
$config->set('databases', []);
$config->set('root_dir', $rootDir);
$config->set('cache_dir', $rootDir . '/var/cache');

$container = new Container();
$container->set('bootstrappers', require 'config/bootstrappers.php');
$container->set('commands', require 'config/commands.php');
$container->set('middlewares', require 'config/middlewares.php');
$container->set('providers', require 'config/migrations.php');
$container->set('providers', require 'config/providers.php');
$container->set('routes', require 'config/routes.php');

foreach ($config->flatten(prepend: 'config.') as $abstract => $concrete) {
    $container->set($abstract, $concrete);
}

return $container;

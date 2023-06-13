<?php

namespace Shared\Infrastructure\Providers;

use Application;
use PhpStandard\Router\Group;
use PhpStandard\Router\Mapper;
use Shared\Infrastructure\ServiceProviderInterface;

/** @package Shared\Infrastructure\Providers */
class RoutingServiceProvider implements ServiceProviderInterface
{
    public function __construct(
        private string $basePath
    ) {
    }

    /**
     * @inheritDoc
     */
    public function register(Application $app): void
    {
        $mapper = new Mapper();

        /** @var Group */
        $group = include $this->basePath . '/routes/routes.php';
        $mapper->add($group);

        $app->set(Mapper::class, $mapper);
    }
}

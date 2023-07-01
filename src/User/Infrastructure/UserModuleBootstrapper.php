<?php

namespace User\Infrastructure;

use Application;
use Shared\Infrastructure\BootstrapperInterface;
use User\Domain\Repositories\UserRepositoryInterface;
use User\Infrastructure\Repositories\DoctrineOrm\UserRepository;

class UserModuleBootstrapper implements BootstrapperInterface
{
    public function __construct(
        private Application $app
    ) {
    }

    public function bootstrap(): void
    {
        // Register repository implementations
        $this->app->set(
            UserRepositoryInterface::class,
            UserRepository::class,
            true
        );
    }
}

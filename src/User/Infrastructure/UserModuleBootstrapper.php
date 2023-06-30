<?php

namespace User\Infrastructure;

use Application;
use Shared\Infrastructure\BootstrapperInterface;
use Shared\Infrastructure\EntityPathFactory;
use User\Domain\Repositories\UserRepositoryInterface;
use User\Infrastructure\Repositories\DoctrineOrm\UserRepository;

class UserModuleBootstrapper implements BootstrapperInterface
{
    public function __construct(
        private EntityPathFactory $entityPathFactory,
        private Application $app
    ) {
    }

    public function bootstrap(): void
    {
        // Register entity paths
        $this->entityPathFactory->add(__DIR__ . '/../Domain/Entities/');
        // $this->commandPathFactory->add(__DIR__ . '/../Application/Commands');

        // Register repository implementations
        $this->app->set(
            UserRepositoryInterface::class,
            UserRepository::class,
            true
        );
    }
}

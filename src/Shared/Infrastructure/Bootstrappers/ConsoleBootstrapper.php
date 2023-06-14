<?php

namespace Shared\Infrastructure\Bootstrappers;

use Application;
use Doctrine\DBAL\Tools\Console\ConnectionProvider;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\ConnectionFromManagerProvider;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerInterface;
use Shared\Infrastructure\BootstrapperInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use Throwable;

class ConsoleBootstrapper implements BootstrapperInterface
{
    public function __construct(
        private ContainerInterface $container,
        private Application $app,
        private string $basePath
    ) {
    }

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        // Bootstrapp only if the application is running in CLI mode
        if (PHP_SAPI !== 'cli') {
            return;
        }

        try {
            /** @var EntityManagerInterface $em */
            $em = $this->container->get(EntityManagerInterface::class);
        } catch (Throwable) {
            $em = null;
        }

        if ($em) {
            $commands = require $this->basePath . '/config/commands.php';

            $emp = new SingleManagerProvider($em);
            $cp = new ConnectionFromManagerProvider($emp);

            $config = new PhpFile($this->basePath . '/config/migrations.php');

            $df = DependencyFactory::fromEntityManager(
                $config,
                new ExistingEntityManager($em)
            );

            $this->app
                ->set(EntityManagerProvider::class, $emp)
                ->set(ConnectionProvider::class, $cp)
                ->set(DependencyFactory::class, $df);
        } else {
            $commands = [];
        }

        $commandLoader = new ContainerCommandLoader(
            $this->container,
            $commands
        );

        $app = new ConsoleApplication('Console');
        $app->setCommandLoader($commandLoader);

        $this->app->set(ConsoleApplication::class, $app);
    }
}
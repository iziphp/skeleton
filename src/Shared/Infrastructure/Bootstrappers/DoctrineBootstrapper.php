<?php

namespace Shared\Infrastructure\Bootstrappers;

use Application;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Exception;
use Shared\Infrastructure\BootstrapperInterface;
use Shared\Infrastructure\EntityPathFactory;

class DoctrineBootstrapper implements BootstrapperInterface
{
    public function __construct(
        private Application $app,
        private EntityPathFactory $entityPathFactory,
        private string $basePath
    ) {
    }

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        $params = $this->getConnectionParams();

        if ($params) {
            $em = $this->getEntityManager($params);

            $this->app
                ->set(EntityManagerInterface::class, $em);
        }
    }

    public function getEntityManager(array $params): EntityManagerInterface
    {
        $proxyDir = $this->basePath . '/cache';

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $this->entityPathFactory->getPaths(),
            isDevMode: true,
            proxyDir: $proxyDir
        );

        $connection = DriverManager::getConnection($params, $config);
        return new EntityManager($connection, $config);
    }

    /**
     * @return null|array 
     * @throws Exception 
     */
    private function getConnectionParams(): ?array
    {
        $driver = env('DB_DRIVER');
        if (!$driver) {
            return null;
        }

        switch ($driver) {
            case 'mysql':
                $connection = $this->getMysqlConnection();
                break;
            case 'sqlite':
                $connection = $this->getSqliteConnection();
                break;
            default:
                throw new Exception('Value of the DB_DRIVER env var is not valid.');
        }

        return $connection;
    }

    /**
     * Get connection config to create MySQL connection
     *
     * @return array
     */
    private function getMysqlConnection(): array
    {
        $connection = [
            'driver' => 'pdo_mysql',
            'user' => env('DB_USER'),
            'password' => env('DB_PASSWORD'),
            'dbname' => env('DB_NAME'),
            'charset' => env('DB_CHARSET')
        ];

        if (env('DB_UNIX_SOCKET')) {
            $connection['unix_socket'] = env('DB_UNIX_SOCKET');
            return $connection;
        }

        $connection['host'] = env('DB_HOST');
        $connection['port'] = env('DB_PORT');

        return $connection;
    }

    /**
     * Get connection config to create SQLite connection
     *
     * @return array
     */
    private function getSqliteConnection(): array
    {
        return [
            'driver' => 'pdo_sqlite',
            'user' => env('DB_USER'),
            'password' => env('DB_PASSWORD'),
            'path' => env('SQLITE_PATH')
        ];
    }
}

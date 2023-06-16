<?php

namespace Shared\Infrastructure\Bootstrappers;

use Dotenv\Dotenv;
use PhpStandard\Container\Attributes\Inject;
use Shared\Infrastructure\BootstrapperInterface;

class ApplicationBootstrapper implements BootstrapperInterface
{
    public function __construct(
        #[Inject('config.root_dir')]
        private string $rootDir
    ) {
    }

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        $this->loadDotenv();
        $this->loadHelperFunctions();
        $this->configErrorReporting();
    }

    /**
     * Load environment variables from the .env file 
     *
     * @return void
     */
    private function loadDotenv()
    {
        Dotenv::createImmutable(
            $this->rootDir
        )->load();
    }

    /**
     * Load helper functions
     *
     * @return void
     */
    private function loadHelperFunctions()
    {
        require_once $this->rootDir . '/helpers/helpers.php';
    }

    /**
     * Configure error reporting
     *
     * @return void
     */
    private function configErrorReporting()
    {
        // Report all errors
        error_reporting(E_ALL);

        // Display error only if debug mode is enabled
        ini_set('display_errors', env('DEBUG', false));
    }
}

<?php

namespace Shared\Infrastructure\Bootstrappers;

use Dotenv\Dotenv;
use Shared\Infrastructure\BootstrapperInterface;

class ApplicationBootstrapper implements BootstrapperInterface
{
    public function __construct(
        private string $basePath
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
            $this->basePath
        )->load();
    }

    /**
     * Load helper functions
     *
     * @return void
     */
    private function loadHelperFunctions()
    {
        require_once $this->basePath . '/helpers/helpers.php';
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

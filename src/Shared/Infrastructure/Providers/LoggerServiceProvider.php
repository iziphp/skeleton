<?php

namespace Shared\Infrastructure\Providers;

use Application;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use PhpStandard\Container\Attributes\Inject;
use Psr\Log\LoggerInterface;
use Shared\Infrastructure\ServiceProviderInterface;

/** @package Shared\Infrastructure\Providers */
class LoggerServiceProvider implements ServiceProviderInterface
{
    /**
     * @param string $logDir 
     * @return void 
     */
    public function __construct(
        #[Inject('config.log_dir')]
        private string $logDir,
    ) {
    }

    /** @inheritDoc */
    public function register(Application $app): void
    {
        $logger = new Logger('app');

        $logger->pushHandler(new StreamHandler($this->logDir . '/app.log'));
        $logger->pushProcessor(new PsrLogMessageProcessor());

        $app->set(LoggerInterface::class, $logger);
    }
}

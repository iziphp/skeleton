<?php

namespace Shared\Infrastructure;

use Application;

/** @package PhpStandard\App */
interface ServiceProviderInterface
{
    /**
     * @param Application $app 
     * @return void 
     */
    public function register(Application $app): void;
}

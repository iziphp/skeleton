<?php

namespace Shared\Infrastructure;

/** @package PhpStandard\App */
interface BootstrapperInterface
{
    /**
     * Method must be invoked after registration 
     * of all ServiceProviderInterface implementations.
     * @return void  
     * */
    public function bootstrap(): void;
}

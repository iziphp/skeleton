<?php

namespace Shared\Infrastructure;

/** @package Shared\Infrastructure */
interface BootstrapperInterface
{
    /**
     * Method must be invoked after registration 
     * of all ServiceProviderInterface implementations.
     * @return void  
     * */
    public function bootstrap(): void;
}

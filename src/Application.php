<?php

use PhpStandard\App\Exceptions\ApplicationException;
use PhpStandard\Container\Container;
use PhpStandard\Container\Exceptions\NotFoundException;
use Shared\Infrastructure\BootstrapperInterface;
use Shared\Infrastructure\ServiceProviderInterface;

/** @package PhpStandard\App */
class Application
{
    /** @var array<ServiceProviderInterface|string> */
    private array $providers = [];

    /** @var array<BootstrapperInterface|string> */
    private array $bootstrappers = [];

    /**
     * @param Container $container 
     * @return void 
     */
    public function __construct(
        private Container $container
    ) {
        $this->container->set(Application::class, $this);
    }

    /**
     * @param (ServiceProviderInterface|string)[] $providers 
     * @return Application 
     */
    public function addServiceProvider(
        ServiceProviderInterface|string ...$providers
    ): self {
        $this->providers = array_merge($this->providers, $providers);
        return $this;
    }

    /**
     * @param (BootstrapperInterface|string)[] $bootstrappers 
     * @return Application 
     */
    public function addBootstrapper(
        BootstrapperInterface|string ...$bootstrappers
    ): self {
        $this->bootstrappers = array_merge($this->bootstrappers, $bootstrappers);
        return $this;
    }

    /**
     * @return void 
     * @throws NotFoundException 
     * @throws Throwable 
     * @throws ApplicationException 
     */
    public function boot(): void
    {
        $this->invokeServiceProviders();
        $this->invokeBootstrappers();
    }

    /**
     * This is a mirror of Container::set(). The purpose of this method is to
     * decouple the ServiceProviderInterface implementation from the 
     * ContainerInterface implementation.
     * 
     * @param string $abstract 
     * @param mixed $concrete 
     * @return Application 
     */
    public function set(
        string $abstract,
        mixed $concrete = null
    ): self {
        $this->container->set($abstract, $concrete);
        return $this;
    }

    /**
     * This is a mirror of Container::setShared(). The purpose of this method is to
     * decouple the ServiceProviderInterface implementation from the 
     * ContainerInterface implementation.
     * 
     * @param string $abstract 
     * @param mixed $concrete 
     * @return Application 
     */
    public function setShared(
        string $abstract,
        mixed $concrete = null
    ): self {
        $this->container->setShared($abstract, $concrete);
        return $this;
    }

    /**
     * @return void 
     * @throws NotFoundException 
     * @throws Throwable 
     * @throws Exception 
     */
    private function invokeServiceProviders(): void
    {
        foreach ($this->providers as $provider) {
            if (is_string($provider)) {
                $provider = $this->container->get($provider);
            }

            if (!($provider instanceof ServiceProviderInterface)) {
                throw new Exception(sprintf(
                    "%s must implement %s",
                    get_class($provider),
                    ServiceProviderInterface::class
                ));
            }

            $provider->register($this);
        }
    }

    /**
     * @return void 
     * @throws NotFoundException 
     * @throws Throwable 
     * @throws Exception 
     */
    private function invokeBootstrappers(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            if (is_string($bootstrapper)) {
                $bootstrapper = $this->container->get($bootstrapper);
            }

            if (!($bootstrapper instanceof BootstrapperInterface)) {
                throw new Exception(sprintf(
                    "%s must implement %s",
                    get_class($bootstrapper),
                    BootstrapperInterface::class
                ));
            }

            $bootstrapper->bootstrap();
        }
    }
}

<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\DI;

use AwdStudio\DI\ContainerFactory;
use AwdStudio\DI\Storage\Registry;
use AwdStudio\Tests\DI\Module\Services\DummyService;
use AwdStudio\Tests\DI\Module\Services\DummyServiceFactory;
use AwdStudio\Tests\DI\Module\Services\DummyServiceForFactory;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithName;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgument;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithNamedArgument;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithAutowiredArguments;

final class DumpContainerWithServices
{

    const SERVICE_WITH_ARGUMENTS = 'service.with.arguments';

    /** @var \AwdStudio\DI\Storage\ServiceRegistry */
    public $registry;

    /** @var \AwdStudio\DI\DIContainer */
    public $container;


    public function __construct()
    {
        $this->registry = new Registry();
        $this->container = ContainerFactory::build($this->registry);

        $this->registerServices();
    }

    private function registerServices()
    {
        $this->registry
            ->register(DummyService::class);

        $this->registry
            ->register(DummyServiceWithName::name)
            ->class(DummyServiceWithName::class);

        $this->registry
            ->register(DummyServiceWithArgument::class)
            ->arguments([DummyService::class]);

        $this->registry
            ->register(DumpServiceWithNamedArgument::class)
            ->arguments(['@' . DummyServiceWithName::name]);

        $this->registry
            ->register(DummyServiceWithAutowiredArguments::class);

        $this->registry
            ->register(DummyServiceForFactory::class)
            ->factory(DummyServiceFactory::class, 'build');
    }

}

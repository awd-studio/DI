<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\DI;

use AwdStudio\DI\ContainerFactory;
use AwdStudio\DI\Storage\Registry;
use AwdStudio\Tests\DI\Module\Services\DumpService;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithName;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithArgument;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithNamedArgument;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithAutowiredArguments;

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
            ->register(DumpService::class);

        $this->registry
            ->register(DumpServiceWithName::name)
            ->class(DumpServiceWithName::class);

        $this->registry
            ->register(DumpServiceWithArgument::class)
            ->arguments([DumpService::class]);

        $this->registry
            ->register(DumpServiceWithNamedArgument::class)
            ->arguments(['@' . DumpServiceWithName::name]);

        $this->registry
            ->register(DumpServiceWithAutowiredArguments::class);
    }

}

<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\DI;

use AwdStudio\DI\ContainerFactory;
use AwdStudio\DI\Storage\Registry;
use AwdStudio\Tests\DI\Module\Services\DummyService;
use AwdStudio\Tests\DI\Module\Services\DummyServiceFactory;
use AwdStudio\Tests\DI\Module\Services\DummyServiceFactoryForCallableStatic;
use AwdStudio\Tests\DI\Module\Services\DummyServiceForCallableWithArray;
use AwdStudio\Tests\DI\Module\Services\DummyServiceForCallableWithStaticMethodString;
use AwdStudio\Tests\DI\Module\Services\DummyServiceForFactory;
use AwdStudio\Tests\DI\Module\Services\DummyServiceTaggable;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgumentFroCallable;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithName;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgument;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithNamedArgument;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithAutowiredArguments;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithNameForCallable;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithTagOne;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithTagTwo;

final class DummyContainerWithServices
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
        // Include functions pack
        require_once __DIR__ . '/../Services/common.php';

        $this->registry
            ->register(DummyService::class);

        $this->registry
            ->register(DummyServiceWithName::name)
            ->class(DummyServiceWithName::class);

        $this->registry
            ->register(DummyServiceWithArgument::class)
            ->arguments([DummyService::class]);

        $this->registry
            ->register(DummyServiceWithNamedArgument::class)
            ->arguments(['@' . DummyServiceWithName::name]);

        $this->registry
            ->register(DummyServiceWithAutowiredArguments::class);

        $this->registry
            ->register(DummyServiceForFactory::class)
            ->factory(DummyServiceFactory::class, DummyServiceFactory::FACTORY_METHOD_NAME);

        $this->registry
            ->register(DummyServiceWithNameForCallable::name)
            ->class(DummyServiceWithNameForCallable::class)
            ->fromCallable('dummyFunctionFactory');

        $this->registry
            ->register(DummyServiceWithNameForCallable::name)
            ->class(DummyServiceWithNameForCallable::class)
            ->fromCallable('\AwdStudio\Tests\DI\Module\Services\dummyFunctionFactory');

        $this->registry
            ->register(DummyServiceWithArgumentFroCallable::class)
            ->fromCallable('\AwdStudio\Tests\DI\Module\Services\dummyFunctionFactoryWithArguments');

        $this->registry
            ->register(DummyServiceForCallableWithArray::class)
            ->fromCallable([
                DummyServiceFactoryForCallableStatic::class,
                DummyServiceFactoryForCallableStatic::FACTORY_METHOD_NAME,
            ]);

        $this->registry
            ->register(DummyServiceWithTagOne::class);
        $this->registry->tag(DummyServiceTaggable::TAG, DummyServiceWithTagOne::class, 2);

        $this->registry
            ->register(DummyServiceWithTagTwo::class);
        $this->registry->tag(DummyServiceTaggable::TAG, DummyServiceWithTagTwo::class, 1);
    }

}

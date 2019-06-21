<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Reflection\TypeHandler;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Storage\ServiceHolder;

final class FactoryTypeHandler extends TypeHandler
{

    /**
     * {@inheritDoc}
     */
    public static function isAppropriate(ServiceHolder $serviceHolder): bool
    {
        return ServiceHolder::TYPE_FACTORY === $serviceHolder->type();
    }

    /**
     * {@inheritDoc}
     */
    protected function buildService(ServiceHolder $serviceHolder, DIContainer $container)
    {
        $factory = new \ReflectionClass($serviceHolder->readFactory());
        $definedArgs = $serviceHolder->readArguments();
        $factoryArguments = $this->prepareArguments($definedArgs, $factory->getConstructor());
        $factoryClass = $factory->newInstanceArgs($factoryArguments);

        $factoryMethod = $factory->getMethod($serviceHolder->readFactoryMethod());
        $factoryMethodDefArgs = $serviceHolder->readFactoryArguments();
        $factoryMethodArguments = $this->prepareArguments($factoryMethodDefArgs, $factoryMethod);
        $resolvedArguments = $this->resolveArguments($factoryMethodArguments, $container);

        return $factoryMethod->invokeArgs($factoryClass, $resolvedArguments);
    }

}

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
        $class = $serviceHolder->readFactory();
        $definedArgs = $serviceHolder->readArguments();
        $factoryClass = $this->resolveObjectConstructor($class, $definedArgs, $container);

        $method = $serviceHolder->readFactoryMethod();
        $definedArgs = $serviceHolder->readFactoryArguments();

        return $this->resolveObjectMethod($factoryClass, $method, $definedArgs, $container);
    }

}

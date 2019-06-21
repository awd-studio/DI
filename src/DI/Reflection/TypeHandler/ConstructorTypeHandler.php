<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Reflection\TypeHandler;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Storage\ServiceHolder;

final class ConstructorTypeHandler extends TypeHandler
{

    /**
     * {@inheritDoc}
     */
    public static function isAppropriate(ServiceHolder $serviceHolder): bool
    {
        return ServiceHolder::TYPE_CONSTRUCTOR === $serviceHolder->type();
    }

    /**
     * {@inheritDoc}
     */
    protected function buildService(ServiceHolder $serviceHolder, DIContainer $container)
    {
        $class = new \ReflectionClass($serviceHolder->readClass());
        $definedArgs = $serviceHolder->readArguments();
        $arguments = $this->prepareArguments($definedArgs, $class->getConstructor());

        return $class->newInstanceArgs($this->resolveArguments($arguments, $container));
    }

}

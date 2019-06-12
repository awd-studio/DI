<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Reflection\TypeHandler;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Exception\ServiceRunException;
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
    public function handle(ServiceHolder $serviceHolder, DIContainer $container)
    {
        return $this->buildService($serviceHolder, $container);
    }

    /**
     * Builds the service from the reflection.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     * @param \AwdStudio\DI\DIContainer           $container
     *
     * @return object
     * @throws \AwdStudio\DI\Exception\InvalidServiceDefinition
     * @throws \AwdStudio\DI\Exception\ServiceRunException
     */
    private function buildService(ServiceHolder $serviceHolder, DIContainer $container)
    {
        try {
            $class = new \ReflectionClass($serviceHolder->readClass());
            $definedArgs = $serviceHolder->readArguments();
            $arguments = $this->prepareArguments($definedArgs, $class->getConstructor());

            return $class->newInstanceArgs($this->resolveArguments($arguments, $container));
        } catch (\ReflectionException $exception) {
            throw new ServiceRunException($exception->getMessage());
        }
    }

}

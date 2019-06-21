<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Reflection\TypeHandler;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Storage\ServiceHolder;

final class CallableTypeHandler extends TypeHandler
{

    /**
     * {@inheritDoc}
     */
    public static function isAppropriate(ServiceHolder $serviceHolder): bool
    {
        return ServiceHolder::TYPE_CALLABLE === $serviceHolder->type();
    }

    /**
     * {@inheritDoc}
     */
    protected function buildService(ServiceHolder $serviceHolder, DIContainer $container)
    {
        $definedArgs = $serviceHolder->readArguments();

        return $this->resolveCallableByType($serviceHolder->readCallableFactory(), $definedArgs, $container);
    }

    /**
     * Resolves the service either for a function, or for a class method.
     *
     * @param callable                  $callable
     * @param array                     $definedArgs
     * @param \AwdStudio\DI\DIContainer $container
     *
     * @return mixed
     * @throws \ReflectionException
     */
    private function resolveCallableByType(callable $callable, array $definedArgs, DIContainer $container)
    {
        if (\is_array($callable)) {
            return $this->resolveMethod($callable[0], $callable[1], $definedArgs, $container);
        }

        return $this->resolveFunction($callable, $definedArgs, $container);
    }

    /**
     * Resolves a service for a class method.
     *
     * @param object                    $class
     * @param string                    $name
     * @param array                     $definedArgs
     * @param \AwdStudio\DI\DIContainer $container
     *
     * @return mixed
     * @throws \ReflectionException
     */
    private function resolveMethod($class, string $name, array $definedArgs, DIContainer $container)
    {
        $reflection = new \ReflectionMethod($class, $name);
        $arguments = $this->prepareArguments($definedArgs, $reflection);
        $object = $this->resolveFactoryObject($class, $container);

        return $reflection->invokeArgs($object, $this->resolveArguments($arguments, $container));
    }

    /**
     * Resolves a service for a function.
     *
     * @param mixed                     $callable
     * @param array                     $definedArgs
     * @param \AwdStudio\DI\DIContainer $container
     *
     * @return mixed
     * @throws \ReflectionException
     */
    private function resolveFunction($callable, array $definedArgs, DIContainer $container)
    {
        $reflection = new \ReflectionFunction($callable);
        $arguments = $this->prepareArguments($definedArgs, $reflection);

        return $reflection->invokeArgs($this->resolveArguments($arguments, $container));
    }

    /**
     * Creates an instance of a class.
     *
     * @param string|object $class
     * @param DIContainer   $container
     *
     * @return object
     * @throws \ReflectionException
     */
    private function resolveFactoryObject($class, DIContainer $container)
    {
        $reflection = new \ReflectionClass($class);
        $arguments = $this->prepareArguments([], $reflection->getConstructor());

        return $reflection->newInstanceArgs($this->resolveArguments($arguments, $container));
    }

}

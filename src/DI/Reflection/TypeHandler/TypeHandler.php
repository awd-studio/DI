<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Reflection\TypeHandler;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Exception\ServiceRunException;
use AwdStudio\DI\Storage\ServiceHolder;

abstract class TypeHandler
{

    /**
     * Builds the list of arguments for the method.
     *
     * @param array                            $definedArgs
     * @param \ReflectionFunctionAbstract|null $method
     *
     * @return array
     */
    protected function prepareArguments(array $definedArgs, ?\ReflectionFunctionAbstract $method): array
    {
        return \array_replace($this->requiredArguments($method), $definedArgs) ?? [];
    }

    /**
     * Returns the list of method parameters.
     *
     * @param \ReflectionFunctionAbstract|null $method
     *
     * @return array
     */
    protected function requiredArguments(?\ReflectionFunctionAbstract $method): array
    {
        return (null !== $method) ? \array_map([$this, 'parameterType'], $method->getParameters()) : [];
    }

    /**
     * Fetches the type of a parameter.
     *
     * @param \ReflectionParameter $parameter
     *
     * @return string|null
     */
    protected function parameterType(\ReflectionParameter $parameter): ?string
    {
        return $parameter->getClass()->name ?? null;
    }

    /**
     * Resolves the arguments for a service.
     *
     * @param array                     $arguments
     * @param \AwdStudio\DI\DIContainer $container
     *
     * @return array
     */
    protected function resolveArguments(array $arguments, DIContainer $container): array
    {
        return \array_map([$container, 'get'], $arguments);
    }

    /**
     * Resolves the class by reflection.
     *
     * @param mixed                     $class       Class to instantiate.
     * @param array                     $definedArgs Default arguments that doesn't need to be resolved.
     * @param \AwdStudio\DI\DIContainer $container   The container for arguments that need to be resolved.
     *
     * @return object
     * @throws \ReflectionException
     */
    protected function resolveObjectConstructor($class, array $definedArgs, DIContainer $container)
    {
        $class = new \ReflectionClass($class);
        $arguments = $this->prepareArguments($definedArgs, $class->getConstructor());

        return $class->newInstanceArgs($this->resolveArguments($arguments, $container));
    }

    /**
     * Resolves the method of an object by reflection.
     *
     * @param object                    $object      An instance of object that contains the method.
     * @param string                    $method      The method's name.
     * @param array                     $definedArgs Default arguments that doesn't need to be resolved.
     * @param \AwdStudio\DI\DIContainer $container   The container for arguments that need to be resolved.
     *
     * @return mixed
     * @throws \ReflectionException
     */
    protected function resolveObjectMethod($object, string $method, array $definedArgs, DIContainer $container)
    {
        $factoryMethod = new \ReflectionMethod($object, $method);
        $factoryMethodArguments = $this->prepareArguments($definedArgs, $factoryMethod);
        $resolvedArguments = $this->resolveArguments($factoryMethodArguments, $container);

        return $factoryMethod->invokeArgs($object, $resolvedArguments);
    }

    /**
     * Handles the service.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     * @param \AwdStudio\DI\DIContainer           $container
     *
     * @return mixed
     * @throws \AwdStudio\DI\Exception\ServiceRunException
     * @throws \AwdStudio\DI\Exception\InvalidServiceDefinition
     */
    public function handle(ServiceHolder $serviceHolder, DIContainer $container)
    {
        try {
            return $this->buildService($serviceHolder, $container);
        } catch (\ReflectionException $exception) {
            throw new ServiceRunException($exception->getMessage());
        }
    }

    /**
     * Checks if the handler is appropriate for a service holder.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     *
     * @return bool
     */
    abstract public static function isAppropriate(ServiceHolder $serviceHolder): bool;

    /**
     * Builds the service from the reflection.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     * @param \AwdStudio\DI\DIContainer           $container
     *
     * @return object
     * @throws \ReflectionException
     * @throws \AwdStudio\DI\Exception\InvalidServiceDefinition
     */
    abstract protected function buildService(ServiceHolder $serviceHolder, DIContainer $container);

}

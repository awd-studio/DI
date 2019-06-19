<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Storage;

interface ServiceHolder
{

    const TYPE_CONSTRUCTOR = 0;
    const TYPE_FACTORY = 1;
    const TYPE_STATIC = 2;
    const TYPE_FUNCTION = 3;

    /**
     * Registers the class which the service provides.
     *
     * @param string $className Full class name with a namespace.
     *
     * @return \AwdStudio\DI\Storage\ServiceHolder
     */
    public function class(string $className): self;

    /**
     * Registers the list of parameters to add to the constructor.
     *
     * @param array $arguments A list of arguments to instantiate the service with.
     *
     * @return \AwdStudio\DI\Storage\ServiceHolder
     */
    public function arguments(array $arguments): self;

    /**
     * Registers the factory that need to call to instantiate the service.
     *
     * @param string $factoryClass Full class name with a namespace.
     * @param string $method       The method which builds the service.
     * @param array  $arguments    Arguments for the factory method.
     *
     * @return \AwdStudio\DI\Storage\ServiceHolder
     */
    public function factory(string $factoryClass, string $method, array $arguments = []): self;

    /**
     * Returns the ID of the service.
     *
     * @return string
     */
    public function id(): string;

    /**
     * Returns type of service.
     *
     * @return int Either of type constants.
     */
    public function type(): int;

    /**
     * Checks if the service matches by it's ID.
     *
     * @param string $id
     *
     * @return bool
     */
    public function isA(string $id): bool;

    /**
     * Returns the class name with namespace.
     *
     * @return string
     * @throws \AwdStudio\DI\Exception\InvalidServiceDefinition
     */
    public function readClass(): string;

    /**
     * Returns the arguments for the constructor.
     *
     * @return array
     * @throws \AwdStudio\DI\Exception\InvalidServiceDefinition
     */
    public function readArguments(): array;

    /**
     * Returns the factory classname.
     *
     * @return string
     */
    public function readFactory(): string;

    /**
     * Returns the factory building method name.
     *
     * @return string
     */
    public function readFactoryMethod(): string;

    /**
     * Returns the list of defined arguments for a factory's method.
     *
     * @return array
     */
    public function readFactoryArguments(): array;

}

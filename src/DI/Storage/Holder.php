<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Storage;

final class Holder implements ServiceHolder
{

    /** @var string */
    private $name;

    /** @var string */
    private $class;

    /** @var string */
    private $factory;

    /** @var array */
    private $arguments = [];

    public function __construct(string $name) {
        $this->name = $name;
        $this->class = $name;
    }

    /**
     * {@inheritDoc}
     */
    public function id(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function type(): int
    {
        if (NULL !== $this->factory) {
            return ServiceHolder::TYPE_FACTORY;
        }

        // ToDo
        // if () {
        //     return ServiceHolder::TYPE_STATIC;
        // }

        // ToDo
        // if () {
        //     return ServiceHolder::TYPE_FUNCTION;
        // }

        return ServiceHolder::TYPE_CONSTRUCTOR;
    }

    /**
     * {@inheritDoc}
     */
    public function isA(string $id): bool
    {
        return $this->name === $id || $this->class === $id;
    }

    /**
     * {@inheritDoc}
     */
    public function readClass(): string
    {
        return $this->class ?? $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function readArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Registers the class which the service provides.
     *
     * @param string $className Full class name with a namespace.
     *
     * @return \AwdStudio\DI\Storage\ServiceHolder
     */
    public function class(string $className): ServiceHolder
    {
        $this->class = $className;

        return $this;
    }

    /**
     * Registers the list of parameters to add to the constructor.
     *
     * @param array $arguments A list of arguments to instantiate the service with.
     *
     * @return \AwdStudio\DI\Storage\ServiceHolder
     */
    public function arguments(array $arguments): ServiceHolder
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Registers the factory that need to call to instantiate the service.
     *
     * @param string $factoryClass Full class name with a namespace.
     * @param string $method       The method which builds the service.
     * @param array  $arguments    Arguments for the factory method.
     *
     * @return \AwdStudio\DI\Storage\ServiceHolder
     */
    public function factory(string $factoryClass, string $method, array $arguments = []): ServiceHolder
    {
        $this->factory = $factoryClass;
        // ToDo

        return $this;
    }

}

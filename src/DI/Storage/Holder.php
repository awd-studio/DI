<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Storage;

final class Holder implements ServiceHolder
{

    /** @var int */
    private $serviceType;

    /** @var string */
    private $name;

    /** @var string */
    private $class;

    /** @var string */
    private $factory;

    /** @var string */
    private $method;

    /** @var array */
    private $arguments;

    public function __construct(
        string $name,
        ?string $class = null,
        ?string $factory = null,
        ?string $method = null,
        array $arguments = []
    ) {
        $this->name = $name;
        $this->class = $class;
        $this->factory = $factory;
        $this->method = $method;
        $this->arguments = $arguments;
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
        return $this->serviceType;
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
        // TODO: Implement getClass() method.
    }

    /**
     * {@inheritDoc}
     */
    public function readArguments(): array
    {
        // TODO: Implement getArguments() method.
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
        // TODO: Implement class() method.
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
        // TODO: Implement arguments() method.
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
        // TODO: Implement factory() method.
    }

}

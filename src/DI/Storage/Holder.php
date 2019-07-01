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

    /** @var callable */
    private $callableFactory;

    /** @var string */
    private $factoryMethod;

    /** @var array */
    private $factoryArguments = [];

    /** @var array */
    private $arguments = [];

    public function __construct(string $name)
    {
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
     *
     * @todo Provide the checker to disallow cross-typing.
     */
    public function type(): int
    {
        if (null !== $this->factory) {
            return ServiceHolder::TYPE_FACTORY;
        }

        if (null !== $this->callableFactory) {
            return ServiceHolder::TYPE_CALLABLE;
        }


        return ServiceHolder::TYPE_CONSTRUCTOR;
    }

    /**
     * {@inheritDoc}
     */
    public function nameIs(string $id): bool
    {
        return $this->name === $id;
    }

    /**
     * {@inheritDoc}
     */
    public function classIs(string $className): bool
    {
        return $this->class === $className;
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
     * {@inheritDoc}
     */
    public function readFactory(): string
    {
        return $this->factory;
    }

    /**
     * Returns the factory building method name.
     *
     * @return string
     */
    public function readFactoryMethod(): string
    {
        return $this->factoryMethod;
    }

    /**
     * {@inheritDoc}
     */
    public function readFactoryArguments(): array
    {
        return $this->factoryArguments;
    }

    /**
     * Returns the callable factory.
     *
     * @return callable
     */
    public function readCallableFactory(): callable
    {
        return $this->callableFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function class(string $className): ServiceHolder
    {
        $this->class = $className;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function arguments(array $arguments): ServiceHolder
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function factory(string $factoryClass, string $method, array $arguments = []): ServiceHolder
    {
        $this->factory = $factoryClass;
        $this->factoryMethod = $method;
        $this->factoryArguments = $arguments;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function fromCallable(callable $callableFactory): ServiceHolder
    {
        $this->callableFactory = $callableFactory;

        return $this;
    }

}

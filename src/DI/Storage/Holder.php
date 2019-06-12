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

}

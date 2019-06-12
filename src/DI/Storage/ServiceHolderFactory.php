<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Storage;

final class ServiceHolderFactory
{

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

    public function __construct(string $name, ?string $class = null)
    {
        $this->name = $name;
        $this->class = $class;
    }

    public function build(): ServiceHolder
    {
        return new Holder(
            $this->name,
            $this->class,
            $this->factory,
            $this->method,
            $this->arguments
        );
    }

}

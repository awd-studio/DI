<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DummyServiceWithAutowiredArguments
{

    /** @var \AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgument */
    private $argument;

    /** @var \AwdStudio\Tests\DI\Module\Services\DummyServiceWithNamedArgument */
    private $namedArgument;

    /**
     * DumpService3 constructor.
     *
     * @param \AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgument      $argument
     * @param \AwdStudio\Tests\DI\Module\Services\DummyServiceWithNamedArgument $namedArgument
     */
    public function __construct(DummyServiceWithArgument $argument, DummyServiceWithNamedArgument $namedArgument)
    {
        $this->argument = $argument;
        $this->namedArgument = $namedArgument;
    }

}

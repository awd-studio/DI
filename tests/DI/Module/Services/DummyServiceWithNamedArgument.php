<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DummyServiceWithNamedArgument
{

    /** @var \AwdStudio\Tests\DI\Module\Services\DummyServiceWithName */
    private $argument;

    /**
     * DumpService3 constructor.
     *
     * @param \AwdStudio\Tests\DI\Module\Services\DummyServiceWithName $argument
     */
    public function __construct(DummyServiceWithName $argument)
    {
        $this->argument = $argument;
    }

}

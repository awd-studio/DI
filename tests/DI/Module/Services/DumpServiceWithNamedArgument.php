<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DumpServiceWithNamedArgument
{

    /** @var \AwdStudio\Tests\DI\Module\Services\DumpServiceWithName */
    private $argument;

    /**
     * DumpService3 constructor.
     *
     * @param \AwdStudio\Tests\DI\Module\Services\DumpServiceWithName $argument
     */
    public function __construct(DumpServiceWithName $argument)
    {
        $this->argument = $argument;
    }

}

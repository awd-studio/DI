<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DumpServiceWithAutowiredArguments
{

    /** @var \AwdStudio\Tests\DI\Module\Services\DumpServiceWithArgument */
    private $argument;

    /** @var \AwdStudio\Tests\DI\Module\Services\DumpServiceWithNamedArgument */
    private $namedArgument;

    /**
     * DumpService3 constructor.
     *
     * @param \AwdStudio\Tests\DI\Module\Services\DumpServiceWithArgument      $argument
     * @param \AwdStudio\Tests\DI\Module\Services\DumpServiceWithNamedArgument $namedArgument
     */
    public function __construct(DumpServiceWithArgument $argument, DumpServiceWithNamedArgument $namedArgument)
    {
        $this->argument = $argument;
        $this->namedArgument = $namedArgument;
    }

}

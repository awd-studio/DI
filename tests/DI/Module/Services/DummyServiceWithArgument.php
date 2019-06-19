<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DummyServiceWithArgument
{

    /** @var \AwdStudio\Tests\DI\Module\Services\DummyService */
    private $argument;

    /**
     * DumpService3 constructor.
     *
     * @param \AwdStudio\Tests\DI\Module\Services\DummyService $argument
     */
    public function __construct(DummyService $argument)
    {
        $this->argument = $argument;
    }

}

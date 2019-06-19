<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DummyServiceForFactory
{

    /** @var \AwdStudio\Tests\DI\Module\Services\DummyService */
    private $argument1;

    /** @var \AwdStudio\Tests\DI\Module\Services\DummyServiceWithAutowiredArguments */
    private $argument2;

    /**
     * DumpServiceForFactory constructor.
     *
     * @param \AwdStudio\Tests\DI\Module\Services\DummyService                       $argument1
     * @param \AwdStudio\Tests\DI\Module\Services\DummyServiceWithAutowiredArguments $argument2
     */
    public function __construct(DummyService $argument1, DummyServiceWithAutowiredArguments $argument2)
    {
        $this->argument1 = $argument1;
        $this->argument2 = $argument2;
    }

}

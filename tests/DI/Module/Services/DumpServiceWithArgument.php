<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DumpServiceWithArgument
{

    /** @var \AwdStudio\Tests\DI\Module\Services\DumpService */
    private $argument;

    /**
     * DumpService3 constructor.
     *
     * @param \AwdStudio\Tests\DI\Module\Services\DumpService $argument
     */
    public function __construct(DumpService $argument)
    {
        $this->argument = $argument;
    }

}

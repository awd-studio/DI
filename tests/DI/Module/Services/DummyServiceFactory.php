<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DummyServiceFactory
{

    public function build(DummyService $argument1, DummyServiceWithAutowiredArguments $argument2): DummyServiceForFactory
    {
        return new DummyServiceForFactory($argument1, $argument2);
    }

}

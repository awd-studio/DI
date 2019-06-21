<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DummyServiceFactory
{

    const FACTORY_METHOD_NAME = 'build';

    public function build(DummyService $argument1, DummyServiceWithAutowiredArguments $argument2): DummyServiceForFactory
    {
        return new DummyServiceForFactory($argument1, $argument2);
    }

}

<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DummyServiceFactoryForCallableStatic
{

    const FACTORY_METHOD_NAME = 'build';
    const SERVICE_NAME = DummyServiceForCallableWithArray::class;

    public static function build(): DummyServiceForCallableWithArray
    {
        return new DummyServiceForCallableWithArray();
    }

}

<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\DI\Module\Services;

class DummyServiceFactoryForCallableNamespaced
{

    const FACTORY_METHOD_NAME = 'build';
    const SERVICE_NAME = DummyService::class;

    public function build(): DummyService
    {
        return new DummyService();
    }

}

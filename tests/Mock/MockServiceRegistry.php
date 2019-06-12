<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\Storage\ServiceRegistry;
use PHPUnit\Framework\MockObject\MockObject;

final class MockServiceRegistry extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        return $this->test
            ->getMockBuilder(ServiceRegistry::class)
            ->getMock();
    }

}

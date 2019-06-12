<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\Storage\ServiceStorage;
use PHPUnit\Framework\MockObject\MockObject;

final class MockServiceStorage extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        return $this->test
            ->getMockBuilder(ServiceStorage::class)
            ->getMock();
    }

}

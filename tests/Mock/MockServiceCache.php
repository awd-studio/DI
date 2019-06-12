<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\Resolver\ServiceCache;
use PHPUnit\Framework\MockObject\MockObject;

final class MockServiceCache extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        return $this->test
            ->getMockBuilder(ServiceCache::class)
            ->getMock();
    }

}

<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\Resolver\ServiceResolver;
use PHPUnit\Framework\MockObject\MockObject;

final class MockServiceResolver extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        return $this->test
            ->getMockBuilder(ServiceResolver::class)
            ->getMock();
    }

}

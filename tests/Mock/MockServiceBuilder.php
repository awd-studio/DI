<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\Builder\ServiceBuilder;
use PHPUnit\Framework\MockObject\MockObject;

final class MockServiceBuilder extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        return $this->test
            ->getMockBuilder(ServiceBuilder::class)
            ->getMock();
    }

}

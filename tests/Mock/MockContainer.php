<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\DIContainer;
use PHPUnit\Framework\MockObject\MockObject;

final class MockContainer extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        return $this->test
            ->getMockBuilder(DIContainer::class)
            ->getMock();
    }

}

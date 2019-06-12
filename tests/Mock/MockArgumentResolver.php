<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\Argument\ArgumentResolver;
use PHPUnit\Framework\MockObject\MockObject;

final class MockArgumentResolver extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        return $this->test
            ->getMockBuilder(ArgumentResolver::class)
            ->getMock();
    }

}

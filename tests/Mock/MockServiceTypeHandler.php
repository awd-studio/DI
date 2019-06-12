<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\Reflection\TypeHandler\TypeHandler;
use PHPUnit\Framework\MockObject\MockObject;

final class MockServiceTypeHandler extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        return $this->test
            ->getMockBuilder(TypeHandler::class)
            ->getMock();
    }

}

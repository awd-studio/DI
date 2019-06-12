<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\Reflection\HandlerResolver;
use PHPUnit\Framework\MockObject\MockObject;

final class MockHandlerResolver extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        $argumentsResolver = MockArgumentResolver::getMock($this->test);

        return $this->test
            ->getMockBuilder(HandlerResolver::class)
            ->setConstructorArgs([$argumentsResolver])
            ->getMock();
    }

}

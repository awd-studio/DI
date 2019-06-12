<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\Tests\Mock;

use AwdStudio\DI\Storage\ServiceHolder;
use DG\BypassFinals;
use PHPUnit\Framework\MockObject\MockObject;

final class MockServiceHolder extends BaseMocker
{

    /**
     * {@inheritDoc}
     */
    protected function buildMock(): MockObject
    {
        // Removes all of "final" tokens
        BypassFinals::enable();

        return $this->test
            ->getMockBuilder(ServiceHolder::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

}

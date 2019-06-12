<?php

namespace AwdStudio\Tests\DI\Unit\Reflection\TypeHandler;

use AwdStudio\DI\Reflection\TypeHandler\StaticTypeHandler;
use AwdStudio\DI\Storage\ServiceHolder;
use AwdStudio\Tests\Mock\MockServiceHolder;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Reflection\TypeHandler\StaticTypeHandler
 */
class StaticHandlerTest extends TestCase
{

    /**
     * @covers       ::isAppropriate
     * @dataProvider appropriationDataProvider
     */
    public function testIsAppropriate(int $type, bool $value)
    {
        $serviceHolder = MockServiceHolder::getMock($this);
        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn($type);

        /** @var \AwdStudio\DI\Storage\ServiceHolder $serviceHolder */
        $this->assertEquals($value, StaticTypeHandler::isAppropriate($serviceHolder));
    }

    public function appropriationDataProvider()
    {
        return [
            [ServiceHolder::TYPE_STATIC, true],
            [42, false],
        ];
    }

    /**
     * @covers ::handle
     * @todo
     */
//    public function testHandle()
//    {
//
//    }

}

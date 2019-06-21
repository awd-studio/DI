<?php

namespace AwdStudio\Tests\DI\Unit\Reflection\TypeHandler;

use AwdStudio\DI\Exception\ServiceRunException;
use AwdStudio\DI\Reflection\TypeHandler\ConstructorTypeHandler;
use AwdStudio\DI\Storage\ServiceHolder;
use AwdStudio\Tests\Mock\MockContainer;
use AwdStudio\Tests\Mock\MockServiceHolder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Reflection\TypeHandler\ConstructorTypeHandler
 */
class ConstructorTypeHandlerTest extends TestCase
{

    /**
     * @covers ::isAppropriate
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
        $this->assertEquals($value, ConstructorTypeHandler::isAppropriate($serviceHolder));
    }

    public function appropriationDataProvider()
    {
        return [
            [ServiceHolder::TYPE_CONSTRUCTOR, true],
            [42, false],
        ];
    }

    /**
     * @covers ::handle
     * @covers ::buildService
     */
    public function testHandleWrongService()
    {
        $this->expectException(ServiceRunException::class);

        $instance = new ConstructorTypeHandler();
        $container = MockContainer::getMock($this);
        $serviceHolder = MockServiceHolder::getMock($this);
        $serviceHolder
            ->expects($this->any())
            ->method('readClass')
            ->willReturn('UnknownService');

        /**
         * @var \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
         * @var \AwdStudio\DI\DIContainer           $container
         */
        $instance->handle($serviceHolder, $container);
    }

    /**
     * @covers ::handle
     * @covers ::buildService
     * @covers ::resolveObjectConstructor
     */
    public function testBuildService()
    {
        $instance = new ConstructorTypeHandler();
        $container = MockContainer::getMock($this);
        $serviceHolder = $this->getServiceHolder();

        /**
         * @var \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
         * @var \AwdStudio\DI\DIContainer           $container
         */
        $theService = $instance->handle($serviceHolder, $container);

        $this->assertInstanceOf(\stdClass::class, $theService);
    }

    private function getServiceHolder(): MockObject
    {
        $serviceHolder = MockServiceHolder::getMock($this);

        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn(ServiceHolder::TYPE_CONSTRUCTOR);

        $serviceHolder
            ->expects($this->any())
            ->method('readClass')
            ->willReturn(\stdClass::class);

        $serviceHolder
            ->expects($this->any())
            ->method('readArguments')
            ->willReturn([]);

        return $serviceHolder;
    }

}

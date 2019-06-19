<?php

namespace AwdStudio\Tests\DI\Unit\Reflection\TypeHandler;

use AwdStudio\DI\Exception\ServiceRunException;
use AwdStudio\DI\Reflection\TypeHandler\FactoryTypeHandler;
use AwdStudio\DI\Storage\ServiceHolder;
use AwdStudio\Tests\Mock\MockContainer;
use AwdStudio\Tests\Mock\MockServiceHolder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Reflection\TypeHandler\FactoryTypeHandler
 */
class FactoryTypeHandlerTest extends TestCase
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
        $this->assertEquals($value, FactoryTypeHandler::isAppropriate($serviceHolder));
    }

    public function appropriationDataProvider()
    {
        return [
            [ServiceHolder::TYPE_FACTORY, true],
            [42, false],
        ];
    }

    /**
     * @covers ::handle
     * @covers ::buildService
     */
    public function testHandle()
    {
        $instance = new FactoryTypeHandler();
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

        $class = new class {
            public function build() {
                return new \stdClass();
            }
        };

        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn(ServiceHolder::TYPE_FACTORY);

        $serviceHolder
            ->expects($this->any())
            ->method('readFactory')
            ->willReturn(get_class($class));

        $serviceHolder
            ->expects($this->any())
            ->method('readFactoryMethod')
            ->willReturn('build');

        $serviceHolder
            ->expects($this->any())
            ->method('readFactoryArguments')
            ->willReturn([]);

        return $serviceHolder;
    }

    /**
     * @covers ::handle
     * @covers ::buildService
     */
    public function testHandleWrongService()
    {
        $instance = new FactoryTypeHandler();
        $container = MockContainer::getMock($this);
        $serviceHolder = $this->getWrongServiceHolder();

        $this->expectException(ServiceRunException::class);

        /**
         * @var \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
         * @var \AwdStudio\DI\DIContainer           $container
         */
        $instance->handle($serviceHolder, $container);
    }

    private function getWrongServiceHolder(): MockObject
    {
        $serviceHolder = MockServiceHolder::getMock($this);

        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn(ServiceHolder::TYPE_FACTORY);

        $serviceHolder
            ->expects($this->any())
            ->method('readFactory')
            ->willReturn(\stdClass::class);

        $serviceHolder
            ->expects($this->any())
            ->method('readFactoryMethod')
            ->willReturn('methodThanNotExist');

        $serviceHolder
            ->expects($this->any())
            ->method('readFactoryArguments')
            ->willReturn(['']);

        return $serviceHolder;
    }

}

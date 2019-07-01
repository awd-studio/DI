<?php

namespace AwdStudio\Tests\DI\Unit\Reflection\TypeHandler;

use AwdStudio\DI\Exception\ServiceRunException;
use AwdStudio\DI\Reflection\TypeHandler\CallableTypeHandler;
use AwdStudio\DI\Storage\ServiceHolder;
use AwdStudio\Tests\DI\Module\Services\DummyServiceFactoryForCallable;
use AwdStudio\Tests\Mock\MockContainer;
use AwdStudio\Tests\Mock\MockServiceHolder;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Reflection\TypeHandler\CallableTypeHandler
 */
class CallableTypeHandlerTest extends TestCase
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
        $this->assertEquals($value, CallableTypeHandler::isAppropriate($serviceHolder));
    }

    public function appropriationDataProvider()
    {
        return [
            [ServiceHolder::TYPE_CALLABLE, true],
            [42, false],
        ];
    }

    /**
     * @covers ::handle
     * @covers ::buildService
     * @covers ::resolveCallableByType
     * @covers ::resolveMethod
     * @covers ::resolveFunction
     * @covers ::resolveObjectMethod
     *
     * @dataProvider serviceHolderDataProvider
     */
    public function testBuildService($serviceHolder, string $serviceInstanceType)
    {
        $instance = new CallableTypeHandler();
        $container = MockContainer::getMock($this);

        /**
         * @var \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
         * @var \AwdStudio\DI\DIContainer           $container
         */
        $theService = $instance->handle($serviceHolder, $container);

        $this->assertInstanceOf($serviceInstanceType, $theService);
    }

    public function serviceHolderDataProvider(): array
    {
        return [
            $this->getLambdaCallableFactory(),
            $this->getArrayCallableDynamicFactory(),
            $this->getArrayCallableDummyFactory(),
            $this->getArrayCallableStaticFactory(),
        ];
    }

    private function getLambdaCallableFactory(): array
    {
        $serviceHolder = MockServiceHolder::getMock($this);

        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn(ServiceHolder::TYPE_CALLABLE);

        $value = \stdClass::class;
        $closure = function () { return new \stdClass(); };
        $serviceHolder
            ->expects($this->any())
            ->method('readCallableFactory')
            ->willReturn($closure);

        return [$serviceHolder, $value];
    }

    private function getArrayCallableDynamicFactory(): array
    {
        $serviceHolder = MockServiceHolder::getMock($this);

        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn(ServiceHolder::TYPE_CALLABLE);

        $factory = new class
        {
            public function build()
            {
                return new \stdClass();
            }
        };
        $value = \stdClass::class;
        $serviceHolder
            ->expects($this->any())
            ->method('readCallableFactory')
            ->willReturn([$factory, 'build']);

        return [$serviceHolder, $value];
    }

    private function getArrayCallableDummyFactory(): array
    {
        $serviceHolder = MockServiceHolder::getMock($this);

        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn(ServiceHolder::TYPE_CALLABLE);

        $value = DummyServiceFactoryForCallable::SERVICE_NAME;
        $serviceHolder
            ->expects($this->any())
            ->method('readCallableFactory')
            ->willReturn([new DummyServiceFactoryForCallable(), DummyServiceFactoryForCallable::FACTORY_METHOD_NAME]);

        return [$serviceHolder, $value];
    }

    private function getArrayCallableStaticFactory(): array
    {
        $serviceHolder = MockServiceHolder::getMock($this);

        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn(ServiceHolder::TYPE_CALLABLE);

        $factory = new class
        {
            public static function build()
            {
                return new \stdClass();
            }
        };
        $value = \stdClass::class;
        $serviceHolder
            ->expects($this->any())
            ->method('readCallableFactory')
            ->willReturn([$factory, 'build']);

        return [$serviceHolder, $value];
    }

}

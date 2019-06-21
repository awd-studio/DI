<?php

namespace AwdStudio\Tests\DI\Unit\Reflection;

use AwdStudio\DI\Exception\UnknownServiceType;
use AwdStudio\DI\Reflection\TypeHandler\ConstructorTypeHandler;
use AwdStudio\DI\Reflection\TypeHandler\FactoryTypeHandler;
use AwdStudio\DI\Reflection\TypeHandler\CallableTypeHandler;
use AwdStudio\DI\Reflection\HandlerResolver;
use AwdStudio\DI\Reflection\TypeHandler\StaticTypeHandler;
use AwdStudio\DI\Storage\ServiceHolder;
use AwdStudio\Tests\Mock\MockArgumentResolver;
use AwdStudio\Tests\Mock\MockServiceHolder;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Reflection\HandlerResolver
 */
class HandlerResolverTest extends TestCase
{

    public function differentServiceTypesProvider()
    {
        return [
            [ServiceHolder::TYPE_CONSTRUCTOR, ConstructorTypeHandler::class],
            [ServiceHolder::TYPE_FACTORY, FactoryTypeHandler::class],
            [ServiceHolder::TYPE_CALLABLE, CallableTypeHandler::class],
        ];
    }

    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $argumentsResolver = MockArgumentResolver::getMock($this);
        /** @var \AwdStudio\DI\Argument\ArgumentResolver $argumentsResolver */
        $instance = new HandlerResolver($argumentsResolver);

        $this->assertInstanceOf(HandlerResolver::class, $instance);
    }

    /**
     * @covers ::getHandler
     * @covers ::handlers
     *
     * @dataProvider differentServiceTypesProvider
     */
    public function testGetHandler(int $type, string $expected)
    {
        $argumentResolver = MockArgumentResolver::getMock($this);
        $serviceHolder = MockServiceHolder::getMock($this);
        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn($type);

        /** @var \AwdStudio\DI\Argument\ArgumentResolver $argumentResolver */
        $instance = new HandlerResolver($argumentResolver);

        /** @var \AwdStudio\DI\Storage\ServiceHolder $serviceHolder */
        $this->assertInstanceOf($expected, $instance->getHandler($serviceHolder));
    }

    /**
     * @covers ::getHandler
     * @covers ::handlers
     */
    public function testGetWrongHandler()
    {
        $this->expectException(UnknownServiceType::class);

        $argumentResolver = MockArgumentResolver::getMock($this);
        $serviceHolder = MockServiceHolder::getMock($this);
        $serviceHolder
            ->expects($this->any())
            ->method('type')
            ->willReturn(42);

        /**
         * @var \AwdStudio\DI\Storage\ServiceHolder     $serviceHolder
         * @var \AwdStudio\DI\Argument\ArgumentResolver $argumentResolver
         */
        (new HandlerResolver($argumentResolver))->getHandler($serviceHolder);
    }

}

<?php

namespace AwdStudio\Tests\DI\Unit\Reflection;

use AwdStudio\DI\Builder\ServiceBuilder;
use AwdStudio\DI\Reflection\ReflectionBuilder;
use AwdStudio\Tests\Mock\MockContainer;
use AwdStudio\Tests\Mock\MockHandlerResolver;
use AwdStudio\Tests\Mock\MockServiceHolder;
use AwdStudio\Tests\Mock\MockServiceTypeHandler;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Reflection\ReflectionBuilder
 */
class ReflectionBuilderTest extends TestCase
{

    /**
     * Instance.
     *
     * @var \AwdStudio\DI\Reflection\ReflectionBuilder
     */
    private $instance;


    /**
     * Settings up.
     */
    public function setUp(): void
    {
        parent::setUp();

        $handlerResolver = MockHandlerResolver::getMock($this);
        /** @var \AwdStudio\DI\Reflection\HandlerResolver $handlerResolver */
        $this->instance = new ReflectionBuilder($handlerResolver);
    }

    /**
     * @covers \AwdStudio\DI\Reflection\ReflectionBuilder::__construct
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ServiceBuilder::class, $this->instance);
    }

    /**
     * @covers ::build
     * @covers ::getHandler
     */
    public function testBuild()
    {
        $container = MockContainer::getMock($this);
        $serviceHolder = MockServiceHolder::getMock($this);

        $serviceTypeHandler = MockServiceTypeHandler::getMock($this);
        $serviceTypeHandler
            ->expects($this->any())
            ->method('handle')
            ->willReturn(new \stdClass());

        $handlerResolver = MockHandlerResolver::getMock($this);
        $handlerResolver
            ->expects($this->any())
            ->method('getHandler')
            ->willReturn($serviceTypeHandler);

        /** @var \AwdStudio\DI\Reflection\HandlerResolver $handlerResolver */
        $instance = new ReflectionBuilder($handlerResolver);

        /**
         * @var \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
         * @var \AwdStudio\DI\DIContainer           $container
         */
        $this->assertInstanceOf(\stdClass::class, $instance->build($serviceHolder, $container));
    }

}

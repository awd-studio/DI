<?php

namespace AwdStudio\Tests\DI\Unit\Storage;

use AwdStudio\DI\Exception\ServiceNotDefined;
use AwdStudio\DI\Storage\ServiceHolder;
use AwdStudio\DI\Storage\ServiceStorage;
use AwdStudio\DI\Storage\Storage;
use AwdStudio\Tests\Mock\MockArgumentResolver;
use AwdStudio\Tests\Mock\MockServiceHolder;
use AwdStudio\Tests\Mock\MockServiceRegistry;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Storage\Storage
 */
class StorageTest extends TestCase
{

    /**
     * @covers ::__construct
     */
    public function test__construct()
    {
        $resolver = MockArgumentResolver::getMock($this);
        $registry = MockServiceRegistry::getMock($this);

        /**
         * @var \AwdStudio\DI\Argument\ArgumentResolver $resolver
         * @var \AwdStudio\DI\Storage\ServiceRegistry   $registry
         */
        $instance = new Storage($resolver, $registry);

        $this->assertInstanceOf(ServiceStorage::class, $instance);
    }

    /**
     * @covers ::find
     */
    public function testFindByName()
    {
        $serviceId = \stdClass::class;

        $serviceHolder = MockServiceHolder::getMock($this);
        $serviceHolder
            ->expects($this->any())
            ->method('nameIs')
            ->willReturn(true);

        $resolver = MockArgumentResolver::getMock($this);
        $resolver
            ->expects($this->any())
            ->method('resolve')
            ->willReturn($serviceId);

        $registry = MockServiceRegistry::getMock($this);
        $registry
            ->expects($this->any())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator([$serviceHolder]));

        /**
         * @var \AwdStudio\DI\Argument\ArgumentResolver $resolver
         * @var \AwdStudio\DI\Storage\ServiceRegistry   $registry
         */
        $instance = new Storage($resolver, $registry);

        $actual = $instance->find($serviceId);

        $this->assertInstanceOf(ServiceHolder::class, $actual);
    }

    /**
     * @covers ::find
     */
    public function testFindByClassName()
    {
        $serviceId = 'std.class';
        $serviceClass = \stdClass::class;

        $serviceHolder = MockServiceHolder::getMock($this);
        $serviceHolder
            ->expects($this->any())
            ->method('nameIs')
            ->willReturn(false);
        $serviceHolder->expects($this->any())
            ->method('classIs')
            ->willReturn(true);

        $resolver = MockArgumentResolver::getMock($this);
        $resolver
            ->expects($this->any())
            ->method('resolve')
            ->willReturn($serviceId);

        $registry = MockServiceRegistry::getMock($this);
        $registry
            ->expects($this->any())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator([$serviceHolder]));

        /**
         * @var \AwdStudio\DI\Argument\ArgumentResolver $resolver
         * @var \AwdStudio\DI\Storage\ServiceRegistry   $registry
         */
        $instance = new Storage($resolver, $registry);

        $actual = $instance->find($serviceClass);

        $this->assertInstanceOf(ServiceHolder::class, $actual);
    }

    /**
     * @covers ::find
     */
    public function testFindFail()
    {
        $serviceId = \stdClass::class;
        $resolver = MockArgumentResolver::getMock($this);
        $resolver
            ->expects($this->any())
            ->method('resolve')
            ->willReturn($serviceId);

        $registry = MockServiceRegistry::getMock($this);
        $registry
            ->expects($this->any())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator());

        /**
         * @var \AwdStudio\DI\Argument\ArgumentResolver $resolver
         * @var \AwdStudio\DI\Storage\ServiceRegistry   $registry
         */
        $instance = new Storage($resolver, $registry);

        $this->expectException(ServiceNotDefined::class);
        $instance->find('undefined.service');
    }

}

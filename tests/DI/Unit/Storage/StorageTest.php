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

    private function generateService(bool $isA)
    {
        $serviceHolder = MockServiceHolder::getMock($this);
        $serviceHolder
            ->expects($this->any())
            ->method('isA')
            ->willReturn($isA);

        yield $serviceHolder;
    }

    /**
     * @covers ::find
     */
    public function testFind()
    {
        $serviceId = \stdClass::class;
        $serviceGenTrue = $this->generateService(true);
        $serviceGenFalse = $this->generateService(false);

        $resolver = MockArgumentResolver::getMock($this);
        $resolver
            ->expects($this->any())
            ->method('resolve')
            ->willReturn($serviceId);

        $registry = MockServiceRegistry::getMock($this);
        $registry
            ->expects($this->at(0))
            ->method('getIterator')
            ->willReturn($serviceGenTrue);

        $registry
            ->expects($this->at(1))
            ->method('getIterator')
            ->willReturn($serviceGenFalse);

        /**
         * @var \AwdStudio\DI\Argument\ArgumentResolver $resolver
         * @var \AwdStudio\DI\Storage\ServiceRegistry   $registry
         */
        $instance = new Storage($resolver, $registry);

        $actual = $instance->find($serviceId);

        $this->assertInstanceOf(ServiceHolder::class, $actual);

        $this->expectException(ServiceNotDefined::class);
        $instance->find($serviceId);
    }

}

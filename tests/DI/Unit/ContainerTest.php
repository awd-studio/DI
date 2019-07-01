<?php

namespace AwdStudio\Tests\DI\Unit;

use AwdStudio\DI\Container;
use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Exception\ServiceNotDefined;
use AwdStudio\DI\Resolver\ServiceResolver;
use AwdStudio\DI\Storage\ServiceStorage;
use AwdStudio\Tests\Mock\MockServiceHolder;
use AwdStudio\Tests\Mock\MockServiceResolver;
use AwdStudio\Tests\Mock\MockServiceStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Container
 */
class ContainerTest extends TestCase
{

    /**
     * @covers ::__construct
     */
    public function testInit()
    {
        /** @var \AwdStudio\DI\Resolver\ServiceResolver $mockServiceResolver */
        $mockServiceResolver = MockServiceResolver::getMock($this);
        /** @var \AwdStudio\DI\Storage\ServiceStorage $mockServiceStorage */
        $mockServiceStorage = MockServiceStorage::getMock($this);

        $this->assertInstanceOf(DIContainer::class, new Container($mockServiceStorage, $mockServiceResolver));
    }

    /**
     * @covers ::get
     * @dataProvider containerWithAssetsProvider
     */
    public function testGet(
        Container $instance,
        MockObject $mockServiceStorage,
        MockObject $mockServiceResolver,
        MockObject $mockServiceHolder
    ) {
        $serviceId = 'a.service';

        // If has
        $mockServiceStorage
            ->expects($this->any())
            ->method('find')
            ->willReturn($mockServiceHolder);

        $mockServiceResolver
            ->expects($this->any())
            ->method('resolve')
            ->willReturn(new \stdClass());

        $this->assertInstanceOf(\stdClass::class, $instance->get($serviceId));
    }

    /**
     * @covers       ::has
     * @dataProvider containerWithAssetsProvider
     */
    public function testHas(
        Container $instance,
        MockObject $mockServiceStorage,
        MockObject $mockServiceResolver,
        MockObject $mockServiceHolder
    ) {
        $serviceId = 'a.service';

        // If has
        $mockServiceStorage
            ->expects($this->any())
            ->method('find')
            ->willReturn($mockServiceHolder);
        $this->assertTrue($instance->has($serviceId));

        // If doesn't have
        $mockServiceStorage
            ->expects($this->any())
            ->method('find')
            ->willThrowException(new ServiceNotDefined());
        $this->assertFalse($instance->has($serviceId));
    }

    public function containerWithAssetsProvider()
    {
        $mockServiceResolver = MockServiceResolver::getMock($this);
        $mockServiceStorage = MockServiceStorage::getMock($this);
        $mockServiceHolder = MockServiceHolder::getMock($this);

        /**
         * @var ServiceStorage  $mockServiceStorage
         * @var ServiceResolver $mockServiceResolver
         */
        $instance = new Container($mockServiceStorage, $mockServiceResolver);

        return [[$instance, $mockServiceStorage, $mockServiceResolver, $mockServiceHolder]];
    }

    /**
     * @covers ::findByTag
     */
    public function testFindByTag()
    {
        $mockServiceResolver = MockServiceResolver::getMock($this);
        $mockServiceStorage = MockServiceStorage::getMock($this);
        $mockServiceHolder = MockServiceHolder::getMock($this);

        $mockServiceResolver
            ->expects($this->any())
            ->method('resolve')
            ->willReturn(new \stdClass());

        $mockServiceStorage
            ->expects($this->any())
            ->method('findByTag')
            ->willReturn(new \ArrayIterator([$mockServiceHolder]));

        /**
         * @var ServiceStorage  $mockServiceStorage
         * @var ServiceResolver $mockServiceResolver
         */
        $instance = new Container($mockServiceStorage, $mockServiceResolver);

        $this->assertInstanceOf(\Traversable::class, $instance->findByTag('test.tag'));

        foreach ($instance->findByTag('test.tag') as $serviceHolder) {
            $this->assertInstanceOf(\stdClass::class, $serviceHolder);
        }
    }

}

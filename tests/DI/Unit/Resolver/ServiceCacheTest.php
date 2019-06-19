<?php

namespace AwdStudio\Tests\DI\Unit\Resolver;

use AwdStudio\DI\Resolver\Cache;
use AwdStudio\DI\Resolver\ServiceCache;
use AwdStudio\Tests\Mock\MockContainer;
use AwdStudio\Tests\Mock\MockServiceBuilder;
use AwdStudio\Tests\Mock\MockServiceHolder;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Resolver\Cache
 */
class ServiceCacheTest extends TestCase
{

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        /** @var \AwdStudio\DI\Builder\ServiceBuilder $serviceBuilder */
        $serviceBuilder = MockServiceBuilder::getMock($this);
        $instance = new Cache($serviceBuilder);

        $this->assertInstanceOf(ServiceCache::class, $instance);
    }

    /**
     * @covers ::get
     * @covers ::store
     * @covers ::buildService
     */
    public function testGet()
    {
        $serviceBuilder = MockServiceBuilder::getMock($this);
        /** @var \AwdStudio\DI\Storage\ServiceHolder $mockServiceHolder */
        $mockServiceHolder = MockServiceHolder::getMock($this);
        /** @var \AwdStudio\DI\DIContainer $container */
        $container = MockContainer::getMock($this);

        // New service
        $serviceBuilder
            ->expects($this->at(0))
            ->method('build')
            ->willReturn(new \stdClass());

        /** @var \AwdStudio\DI\Builder\ServiceBuilder $serviceBuilder */
        $instance = new Cache($serviceBuilder);

        $service = $instance->get($mockServiceHolder, $container);
        $this->assertInstanceOf(\stdClass::class, $service);
    }

}

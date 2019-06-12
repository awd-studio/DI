<?php

namespace AwdStudio\Tests\DI\Unit\Resolver;

use AwdStudio\DI\Resolver\Resolver;
use AwdStudio\DI\Resolver\ServiceResolver;
use AwdStudio\Tests\Mock\MockContainer;
use AwdStudio\Tests\Mock\MockServiceCache;
use AwdStudio\Tests\Mock\MockServiceHolder;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Resolver\Resolver
 */
class ResolverTest extends TestCase
{

    /**
     * Instance.
     *
     * @var \AwdStudio\DI\Resolver\ServiceResolver
     */
    private $instance;

    /**
     * Settings up.
     */
    public function setUp(): void
    {
        parent::setUp();

        /** @var \AwdStudio\DI\Resolver\ServiceCache $serviceCache */
        $serviceCache = MockServiceCache::getMock($this);
        $this->instance = new Resolver($serviceCache);
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ServiceResolver::class, $this->instance);
    }

    /**
     * @covers ::resolve
     */
    public function testResolve()
    {
        $serviceCache = MockServiceCache::getMock($this);
        $serviceCache
            ->expects($this->any())
            ->method('get')
            ->willReturn(new \stdClass());

        /** @var \AwdStudio\DI\Resolver\ServiceCache $serviceCache */
        $instance = new Resolver($serviceCache);

        /** @var \AwdStudio\DI\Storage\ServiceHolder $serviceHolder */
        $serviceHolder = MockServiceHolder::getMock($this);

        /** @var \AwdStudio\DI\DIContainer $container */
        $container = MockContainer::getMock($this);

        $this->assertInstanceOf(\stdClass::class, $instance->resolve($serviceHolder, $container));
    }

}

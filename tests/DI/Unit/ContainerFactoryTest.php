<?php

namespace AwdStudio\Tests\DI\Unit;

use AwdStudio\DI\ContainerFactory;
use AwdStudio\DI\DIContainer;
use AwdStudio\Tests\Mock\MockServiceRegistry;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\ContainerFactory
 */
class ContainerFactoryTest extends TestCase
{

    /**
     * @covers ::build
     */
    public function testBuild()
    {
        /** @var \AwdStudio\DI\Storage\ServiceRegistry $registry */
        $registry = MockServiceRegistry::getMock($this);
        $container = ContainerFactory::build($registry);

        $this->assertInstanceOf(DIContainer::class, $container);
    }

}

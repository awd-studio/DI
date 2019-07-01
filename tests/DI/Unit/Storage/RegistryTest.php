<?php

namespace AwdStudio\Tests\DI\Unit\Storage;

use AwdStudio\DI\Storage\Registry;
use AwdStudio\DI\Storage\ServiceHolder;
use AwdStudio\DI\Storage\ServiceRegistry;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Storage\Registry
 */
class RegistryTest extends TestCase
{

    /**
     * Instance.
     *
     * @var \AwdStudio\DI\Storage\Registry
     */
    private $instance;


    /**
     * Settings up.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->instance = new Registry();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(ServiceRegistry::class, $this->instance);
        $this->assertInstanceOf(\IteratorAggregate::class, $this->instance);
    }

    /**
     * @covers ::register
     */
    public function testRegister()
    {
        $serviceName = 'testService';
        $holder = $this->instance->register($serviceName);

        $this->assertInstanceOf(ServiceHolder::class, $holder);
    }

    /**
     * @covers ::getIterator
     */
    public function testGetIterator()
    {
        $serviceName = 'testService';
        $this->instance->register($serviceName);
        $iterator = $this->instance->getIterator();

        $this->assertInstanceOf(\Generator::class, $iterator);

        foreach ($iterator as $instance) {
            $this->assertInstanceOf(ServiceHolder::class, $instance);
        }
    }

}

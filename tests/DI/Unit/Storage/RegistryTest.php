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

        $this->assertInstanceOf(\Traversable::class, $this->instance);

        foreach ($this->instance as $instance) {
            $this->assertInstanceOf(ServiceHolder::class, $instance);
        }
    }

    /**
     * @covers ::tag
     */
    public function testTag()
    {
        $this->assertInstanceOf(ServiceRegistry::class, $this->instance->tag('tag.name', \stdClass::class));
        $this->assertInstanceOf(ServiceRegistry::class, $this->instance->tag('another.tag.name', \stdClass::class, 42));
    }

    /**
     * @covers ::findByTag
     */
    public function testFindByTag()
    {
        $this->assertInstanceOf(\Traversable::class, $this->instance->findByTag('tag.name'));

        $service1_1 = \get_class(new class {});
        $service1_2 = \get_class(new class {});
        $service1_3 = \get_class(new class {});
        $service1_4 = \get_class(new class {});
        $service2_1 = \get_class(new class {});
        $service2_2 = \get_class(new class {});

        $this->instance->tag('tag.name', $service1_1);
        $this->instance->tag('tag.name', $service1_2, 0);
        $this->instance->tag('tag.name', $service1_3, 42);
        $this->instance->tag('tag.name', $service1_4, -1);
        $this->instance->tag('another.tag.name', $service2_1);
        $this->instance->tag('another.tag.name', $service2_2);

        foreach ($this->instance->findByTag('tag.name') as $priority => $serviceId) {
            switch ($priority) {
                case 0:
                    $this->assertSame($service1_4, $serviceId);
                    break;
                case 1:
                    $this->assertSame($service1_1, $serviceId);
                    break;
                case 2:
                    $this->assertSame($service1_2, $serviceId);
                    break;
                case 3:
                    $this->assertSame($service1_3, $serviceId);
                    break;
            }
        }

        foreach ($this->instance->findByTag('another.tag.name') as $priority => $serviceId) {
            switch ($priority) {
                case 0:
                    $this->assertSame($service2_1, $serviceId);
                    break;
                case 1:
                    $this->assertSame($service2_2, $serviceId);
                    break;
            }
        }
    }

}

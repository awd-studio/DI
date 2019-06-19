<?php

namespace AwdStudio\Tests\DI\Module;

use AwdStudio\DI\Exception\ServiceNotDefined;
use AwdStudio\Tests\DI\Module\DI\DumpContainerWithServices;
use AwdStudio\Tests\DI\Module\Services\DumpService;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithName;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithArgument;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithNamedArgument;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithAutowiredArguments;
use PHPUnit\Framework\TestCase;

/**
 * Global modular test to figure out whe whole cases compatibility.
 *
 * @coversDefaultClass \AwdStudio\DI\Container
 *
 * @see \AwdStudio\Tests\DI\Module\DI\DumpContainerWithServices
 */
class ContainerModuleTest extends TestCase
{

    /**
     * Instance.
     *
     * @var \AwdStudio\DI\DIContainer
     */
    private $instance;


    /**
     * Settings up.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->instance = (new DumpContainerWithServices())->container;
    }

    /**
     * @covers ::__construct
     */
    public function testPsrCompatibility()
    {
        $this->assertInstanceOf(\Psr\Container\ContainerInterface::class, $this->instance);
    }

    /**
     * @covers ::get
     */
    public function testGetByClassName()
    {
        $service = $this->instance->get(DumpService::class);

        $this->assertInstanceOf(DumpService::class, $service);
    }

    /**
     * @covers ::get
     */
    public function testGetByServiceName()
    {
        $service = $this->instance->get(DumpServiceWithName::name);

        $this->assertInstanceOf(DumpServiceWithName::class, $service);
    }

    /**
     * @covers ::get
     */
    public function testGetServiceWithArgument()
    {
        $service = $this->instance->get(DumpServiceWithArgument::class);

        $this->assertInstanceOf(DumpServiceWithArgument::class, $service);
    }

    /**
     * @covers ::get
     */
    public function testGetServiceWithNamedArgument()
    {
        $service = $this->instance->get(DumpServiceWithNamedArgument::class);

        $this->assertInstanceOf(DumpServiceWithNamedArgument::class, $service);
    }

    /**
     * @covers ::get
     */
    public function testGetServiceWithAutowiredArgument()
    {
        $service = $this->instance->get(DumpServiceWithAutowiredArguments::class);

        $this->assertInstanceOf(DumpServiceWithAutowiredArguments::class, $service);
    }

    /**
     * @covers ::get
     */
    public function testServiceNotDefinedException()
    {
        $this->expectException(ServiceNotDefined::class);
        $this->instance->get(\stdClass::class);

        $this->expectException(ServiceNotDefined::class);
        $this->instance->get('undefined.service');

        // PSR-compatibility
        $this->expectException(\Psr\Container\NotFoundExceptionInterface::class);
        $this->instance->get(\stdClass::class);

        // PSR-compatibility
        $this->expectException(\Psr\Container\NotFoundExceptionInterface::class);
        $this->instance->get('undefined.service');
    }

    /**
     * @covers ::has
     */
    public function testHasByClassName()
    {
        $this->assertTrue($this->instance->has(DumpService::class));
        $this->assertFalse($this->instance->has(\stdClass::class));
    }

    /**
     * @covers ::has
     */
    public function testHasByServiceName()
    {
        $this->assertTrue($this->instance->has(DumpServiceWithName::name));
        $this->assertFalse($this->instance->has('undefined.service'));
    }

}

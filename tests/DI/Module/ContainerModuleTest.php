<?php

namespace AwdStudio\Tests\DI\Module;

use AwdStudio\DI\Exception\ServiceNotDefined;
use AwdStudio\Tests\DI\Module\DI\DumpContainerWithServices;
use AwdStudio\Tests\DI\Module\Services\DummyService;
use AwdStudio\Tests\DI\Module\Services\DummyServiceForFactory;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithName;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgument;
use AwdStudio\Tests\DI\Module\Services\DumpServiceWithNamedArgument;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithAutowiredArguments;
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
        $service = $this->instance->get(DummyService::class);

        $this->assertInstanceOf(DummyService::class, $service);
    }

    /**
     * @covers ::get
     */
    public function testGetByServiceName()
    {
        $service = $this->instance->get(DummyServiceWithName::name);

        $this->assertInstanceOf(DummyServiceWithName::class, $service);
    }

    /**
     * @covers ::get
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::prepareArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::resolveArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::requiredArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::parameterType
     */
    public function testGetServiceWithArgument()
    {
        $service = $this->instance->get(DummyServiceWithArgument::class);

        $this->assertInstanceOf(DummyServiceWithArgument::class, $service);
    }

    /**
     * @covers ::get
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::prepareArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::resolveArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::requiredArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::parameterType
     */
    public function testGetServiceWithNamedArgument()
    {
        $service = $this->instance->get(DumpServiceWithNamedArgument::class);

        $this->assertInstanceOf(DumpServiceWithNamedArgument::class, $service);
    }

    /**
     * @covers ::get
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::prepareArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::resolveArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::requiredArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::parameterType
     */
    public function testGetServiceWithAutowiredArgument()
    {
        $service = $this->instance->get(DummyServiceWithAutowiredArguments::class);

        $this->assertInstanceOf(DummyServiceWithAutowiredArguments::class, $service);
    }

    /**
     * @covers ::get
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::prepareArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::resolveArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::requiredArguments
     * @covers \AwdStudio\DI\Reflection\TypeHandler\TypeHandler::parameterType
     */
    public function testGetServiceWithFactory()
    {
        $service = $this->instance->get(DummyServiceForFactory::class);

        $this->assertInstanceOf(DummyServiceForFactory::class, $service);
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
        $this->assertTrue($this->instance->has(DummyService::class));
        $this->assertFalse($this->instance->has(\stdClass::class));
    }

    /**
     * @covers ::has
     */
    public function testHasByServiceName()
    {
        $this->assertTrue($this->instance->has(DummyServiceWithName::name));
        $this->assertFalse($this->instance->has('undefined.service'));
    }

}

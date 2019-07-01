<?php

namespace AwdStudio\Tests\DI\Module;

use AwdStudio\DI\Exception\ServiceNotDefined;
use AwdStudio\Tests\DI\Module\DI\DummyContainerWithServices;
use AwdStudio\Tests\DI\Module\Services\DummyService;
use AwdStudio\Tests\DI\Module\Services\DummyServiceForCallableWithArray;
use AwdStudio\Tests\DI\Module\Services\DummyServiceForCallableWithStaticMethodString;
use AwdStudio\Tests\DI\Module\Services\DummyServiceForFactory;
use AwdStudio\Tests\DI\Module\Services\DummyServiceTaggable;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgumentFroCallable;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithName;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithArgument;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithNamedArgument;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithAutowiredArguments;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithNameForCallable;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithTagOne;
use AwdStudio\Tests\DI\Module\Services\DummyServiceWithTagTwo;
use PHPUnit\Framework\TestCase;

/**
 * Global modular test to figure out whe whole cases compatibility.
 *
 * @coversDefaultClass \AwdStudio\DI\Container
 *
 * @see \AwdStudio\Tests\DI\Module\DI\DummyContainerWithServices
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

        $this->instance = (new DummyContainerWithServices())->container;
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
        $service = $this->instance->get(DummyServiceWithNamedArgument::class);

        $this->assertInstanceOf(DummyServiceWithNamedArgument::class, $service);
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
    public function testGetServiceFromCallableFactory()
    {
        $service = $this->instance->get(DummyServiceWithNameForCallable::name);
        $this->assertInstanceOf(DummyServiceWithNameForCallable::class, $service);

        $serviceNamespaced = $this->instance->get(DummyServiceWithNameForCallable::name);
        $this->assertInstanceOf(DummyServiceWithNameForCallable::class, $serviceNamespaced);
    }

    /**
     * @covers ::get
     */
    public function testGetServiceFromCallableFactoryWithArguments()
    {
        $service = $this->instance->get(DummyServiceWithArgumentFroCallable::class);
        $this->assertInstanceOf(DummyServiceWithArgumentFroCallable::class, $service);

        $serviceNamespaced = $this->instance->get(DummyServiceWithArgumentFroCallable::class);
        $this->assertInstanceOf(DummyServiceWithArgumentFroCallable::class, $serviceNamespaced);
    }

    public function testGetServiceFromCallableByArray()
    {
        $service = $this->instance->get(DummyServiceForCallableWithArray::class);
        $this->assertInstanceOf(DummyServiceForCallableWithArray::class, $service);
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

    /**
     * @covers ::findByTag
     */
    public function testFindByTag()
    {
        foreach ($this->instance->findByTag(DummyServiceTaggable::TAG) as $priority => $service) {
            $this->assertInstanceOf(DummyServiceTaggable::class, $service);

            switch ($priority) {
                case 0:
                    $this->assertInstanceOf(DummyServiceWithTagTwo::class, $service);
                    break;
                case 1:
                    $this->assertInstanceOf(DummyServiceWithTagOne::class, $service);
                    break;
            }
        }
    }

}

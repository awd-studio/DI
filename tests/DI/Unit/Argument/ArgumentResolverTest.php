<?php

namespace AwdStudio\Tests\DI\Unit\Argument;

use AwdStudio\DI\Argument\ArgumentResolver;
use AwdStudio\DI\Argument\SkippedArgument;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Argument\ArgumentResolver
 */
class ArgumentResolverTest extends TestCase
{

    /**
     * Instance.
     *
     * @var \AwdStudio\DI\Argument\ArgumentResolver
     */
    private $instance;


    /**
     * Settings up.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->instance = new ArgumentResolver();
    }

    /**
     * @covers ::resolve
     * @covers ::resolversList
     */
    public function testResolve()
    {
        $this->assertSame(\stdClass::class, $this->instance->resolve(\stdClass::class));
        $this->assertSame('test.named.argument', $this->instance->resolve('@test.named.argument'));
        $this->assertSame(42, $this->instance->resolve(42));
        $this->assertSame(null, $this->instance->resolve(SkippedArgument::SKIP));
    }

}

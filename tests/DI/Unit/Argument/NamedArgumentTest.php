<?php

namespace AwdStudio\Tests\DI\Unit\Argument;

use AwdStudio\DI\Argument\NamedArgument;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Argument\NamedArgument
 */
class NamedArgumentTest extends TestCase
{

    /**
     * @covers ::isAppropriate
     */
    public function testIsAppropriate()
    {
        $argument = '@test.service.name';
        $this->assertTrue(NamedArgument::isAppropriate($argument));

        $argument = 'wrong.service.name';
        $this->assertFalse(NamedArgument::isAppropriate($argument));
    }

    /**
     * @covers ::resolve
     */
    public function testResolve()
    {
        $argument = 'test.service.name';

        /** @var \AwdStudio\DI\DIContainer $container */
        $instance = new NamedArgument();

        $this->assertSame($argument, $instance->resolve('@' . $argument));
    }

}

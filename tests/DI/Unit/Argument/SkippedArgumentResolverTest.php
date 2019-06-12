<?php

namespace AwdStudio\Tests\DI\Unit\Argument;

use AwdStudio\DI\Argument\Argument;
use AwdStudio\DI\Argument\SkippedArgument;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Argument\SkippedArgument
 */
class SkippedArgumentResolverTest extends TestCase
{

    /**
     * @covers ::isAppropriate
     */
    public function testIsAppropriate()
    {
        $argument = Argument::SKIP;
        $this->assertTrue(SkippedArgument::isAppropriate($argument));

        $argument = 'wrong.service.name';
        $this->assertFalse(SkippedArgument::isAppropriate($argument));
    }


    /**
     * @covers ::resolve
     */
    public function testResolve()
    {
        $argument = Argument::SKIP;
        $instance = new SkippedArgument();

        $this->assertNull($instance->resolve($argument));
    }

}

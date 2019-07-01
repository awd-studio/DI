<?php

namespace AwdStudio\Tests\DI\Unit\Tagging;

use AwdStudio\DI\Tag\TagContainer;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \AwdStudio\DI\Tag\TagContainer
 */
class TagContainerTest extends TestCase
{

    /**
     * Instance.
     *
     * @var \AwdStudio\DI\Tag\TagContainer
     */
    private $instance;

    /**
     * @var string
     */
    private $tagName;


    /**
     * Settings up.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->tagName = 'test.tag';
        $this->instance = new TagContainer($this->tagName);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(\IteratorAggregate::class, $this->instance);
    }

    /**
     * @covers ::add
     */
    public function testAdd()
    {
        $this->assertInstanceOf(TagContainer::class, $this->instance->add(\stdClass::class));
        $this->assertInstanceOf(TagContainer::class, $this->instance->add('some.service1', 25));
        $this->assertInstanceOf(TagContainer::class, $this->instance->add('the.first.service', -1));
    }

    /**
     * @covers ::getIterator
     * @covers ::sorted
     */
    public function testGetIterator()
    {
        $this->assertInstanceOf(\Traversable::class, $this->instance->getIterator());

        $this->instance->add(\stdClass::class);
        $this->instance->add('some.service1');
        $this->instance->add('some.service2', 25);
        $this->instance->add('the.first.service', -1);

        foreach ($this->instance as $i => $service) {
            switch ($i) {
                case 0:
                    $this->assertSame('the.first.service', $service);
                    break;
                case 1:
                    $this->assertSame(\stdClass::class, $service);
                    break;
                case 2:
                    $this->assertSame('some.service1', $service);
                    break;
                case 3:
                    $this->assertSame('some.service2', $service);
                    break;
            }
        }
    }

}

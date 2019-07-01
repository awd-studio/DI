<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Storage;

use AwdStudio\DI\Tag\TagContainer;

final class Registry implements ServiceRegistry
{

    /** @var array */
    private $registry = [];

    /** @var \AwdStudio\DI\Tag\TagContainer[] */
    private $tags = [];

    /**
     * {@inheritDoc}
     */
    public function register(string $serviceName): ServiceHolder
    {
        $serviceHolder = new Holder($serviceName);
        $this->registry[$serviceHolder->id()] = $serviceHolder;

        return $serviceHolder;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        foreach ($this->registry as $serviceHolder) {
            yield $serviceHolder;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function tag(string $tag, string $service, int $weight = 0): ServiceRegistry {
        $this->tags[$tag] = $this->tags[$tag] ?? new TagContainer($tag);
        $this->tags[$tag]->add($service, $weight);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function findByTag(string $tag): iterable
    {
        $tagContainers = $this->tags[$tag] ?? [];

        foreach ($tagContainers as $serviceId) {
            yield $serviceId;
        }
    }

}

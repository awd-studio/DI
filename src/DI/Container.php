<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI;

use AwdStudio\DI\Exception\ServiceNotDefined;
use AwdStudio\DI\Resolver\ServiceResolver;
use AwdStudio\DI\Storage\ServiceStorage;

final class Container implements DIContainer
{

    /** @var \AwdStudio\DI\Storage\ServiceStorage */
    private $storage;

    /** @var \AwdStudio\DI\Resolver\ServiceResolver */
    private $resolver;

    /**
     * Container constructor.
     *
     * @param \AwdStudio\DI\Storage\ServiceStorage   $storage
     * @param \AwdStudio\DI\Resolver\ServiceResolver $resolver
     */
    public function __construct(ServiceStorage $storage, ServiceResolver $resolver)
    {
        $this->storage = $storage;
        $this->resolver = $resolver;
    }

    /**
     * {@inheritDoc}
     */
    public function get($id)
    {
        $service = $this->storage->find($id);

        return $this->resolver->resolve($service, $this);
    }

    /**
     * {@inheritDoc}
     */
    public function has($id): bool
    {
        try {
            $this->storage->find($id);
        } catch (ServiceNotDefined $e) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function findByTag(string $tag): iterable
    {
        foreach ($this->storage->findByTag($tag) as $serviceHolder) {
            yield $this->resolver->resolve($serviceHolder, $this);
        }
    }

}

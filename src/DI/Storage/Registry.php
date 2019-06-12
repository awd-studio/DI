<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Storage;

final class Registry implements ServiceRegistry
{

    /** @var array */
    private $registry;

    /**
     * {@inheritDoc}
     */
    public function register(string $serviceName): ServiceHolder
    {
        $this->registry[] = $serviceHolder;

        return $serviceHolder;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): iterable
    {
        foreach ($this->registry as $serviceHolder) {
            yield $serviceHolder;
        }
    }

}

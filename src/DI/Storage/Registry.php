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

}

<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Resolver;

use AwdStudio\DI\Builder\ServiceBuilder;
use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Storage\ServiceHolder;

final class Cache implements ServiceCache
{

    /** @var array */
    private $instances = [];

    /** @var \AwdStudio\DI\Builder\ServiceBuilder */
    private $serviceBuilder;

    /**
     * ServiceCache constructor.
     *
     * @param \AwdStudio\DI\Builder\ServiceBuilder $serviceBuilder
     */
    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function get(ServiceHolder $serviceHolder, DIContainer $container)
    {
        $id = $serviceHolder->id();

        if (!isset($this->instances[$id])) {
            $this->store($serviceHolder, $container);
        }

        return $this->instances[$id];
    }

    /**
     * Stores a new service instance into the cache.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     * @param \AwdStudio\DI\DIContainer           $container
     *
     * @throws \AwdStudio\DI\Exception\ServiceRunException
     * @throws \AwdStudio\DI\Exception\UnknownServiceType
     */
    private function store(ServiceHolder $serviceHolder, DIContainer $container)
    {
        $this->instances[$serviceHolder->id()] = $this->buildService($serviceHolder, $container);
    }

    /**
     * Builds the service with a builder.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     * @param \AwdStudio\DI\DIContainer           $container
     *
     * @return mixed
     * @throws \AwdStudio\DI\Exception\ServiceRunException
     * @throws \AwdStudio\DI\Exception\UnknownServiceType
     */
    private function buildService(ServiceHolder $serviceHolder, DIContainer $container)
    {
        return $this->serviceBuilder->build($serviceHolder, $container);
    }

}

<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Resolver;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Storage\ServiceHolder;

final class Resolver implements ServiceResolver
{

    /** @var \AwdStudio\DI\Resolver\ServiceCache */
    private $serviceCache;

    /**
     * Resolver constructor.
     *
     * @param \AwdStudio\DI\Resolver\ServiceCache $serviceCache
     */
    public function __construct(ServiceCache $serviceCache)
    {
        $this->serviceCache = $serviceCache;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(ServiceHolder $serviceHolder, DIContainer $container)
    {
        return $this->serviceCache->get($serviceHolder, $container);
    }

}

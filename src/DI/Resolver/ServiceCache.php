<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Resolver;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Storage\ServiceHolder;

interface ServiceCache
{

    /**
     * Returns a service instance either from a cache or from builder.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     * @param \AwdStudio\DI\DIContainer           $container
     *
     * @return mixed
     * @throws \AwdStudio\DI\Exception\UnknownServiceType
     * @throws \AwdStudio\DI\Exception\ServiceRunException
     */
    public function get(ServiceHolder $serviceHolder, DIContainer $container);

}

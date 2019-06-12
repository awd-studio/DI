<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Resolver;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Storage\ServiceHolder;

interface ServiceResolver
{

    /**
     * Resolves the service instance.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     * @param \AwdStudio\DI\DIContainer           $container
     *
     * @return mixed The service instance.
     * @throws \AwdStudio\DI\Exception\UnknownServiceType
     * @throws \AwdStudio\DI\Exception\ServiceRunException
     */
    public function resolve(ServiceHolder $serviceHolder, DIContainer $container);

}

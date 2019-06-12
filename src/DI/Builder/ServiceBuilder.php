<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Builder;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Storage\ServiceHolder;

interface ServiceBuilder
{

    /**
     * Builds and returns a service from it's registry presentation.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     * @param \AwdStudio\DI\DIContainer           $container
     *
     * @return mixed
     * @throws \AwdStudio\DI\Exception\InvalidServiceDefinition
     * @throws \AwdStudio\DI\Exception\UnknownServiceType
     * @throws \AwdStudio\DI\Exception\ServiceRunException
     */
    public function build(ServiceHolder $serviceHolder, DIContainer $container);

}

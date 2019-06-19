<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI;

use AwdStudio\DI\Argument\ArgumentResolver;
use AwdStudio\DI\Reflection\HandlerResolver;
use AwdStudio\DI\Reflection\ReflectionBuilder;
use AwdStudio\DI\Resolver\Cache;
use AwdStudio\DI\Resolver\Resolver;
use AwdStudio\DI\Storage\ServiceRegistry;
use AwdStudio\DI\Storage\Storage;

final class ContainerFactory
{

    /**
     * Builds a regular service container with the custom registry.
     *
     * @param \AwdStudio\DI\Storage\ServiceRegistry $registry
     *
     * @return \AwdStudio\DI\DIContainer
     */
    public static function build(ServiceRegistry $registry): DIContainer
    {
        $argumentResolver = new ArgumentResolver();
        $handlerResolver  = new HandlerResolver($argumentResolver);
        $serviceBuilder   = new ReflectionBuilder($handlerResolver);
        $serviceCache     = new Cache($serviceBuilder);
        $storage          = new Storage($argumentResolver, $registry);
        $resolver         = new Resolver($serviceCache);

        return new Container($storage, $resolver);
    }

}

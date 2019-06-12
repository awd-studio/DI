<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Reflection;

use AwdStudio\DI\Builder\ServiceBuilder;
use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Reflection\TypeHandler\TypeHandler;
use AwdStudio\DI\Storage\ServiceHolder;

final class ReflectionBuilder implements ServiceBuilder
{

    /** @var \AwdStudio\DI\Reflection\HandlerResolver */
    private $handlerResolver;

    /**
     * ReflectionBuilder constructor.
     *
     * @param \AwdStudio\DI\Reflection\HandlerResolver $handlerResolver
     */
    public function __construct(HandlerResolver $handlerResolver)
    {
        $this->handlerResolver = $handlerResolver;
    }

    /**
     * {@inheritDoc}
     */
    public function build(ServiceHolder $serviceHolder, DIContainer $container)
    {
        $handler = $this->getHandler($serviceHolder);

        return $handler->handle($serviceHolder, $container);
    }

    /**
     * Resolves the handler by the service-container.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     *
     * @return \AwdStudio\DI\Reflection\TypeHandler\TypeHandler
     * @throws \AwdStudio\DI\Exception\UnknownServiceType
     */
    private function getHandler(ServiceHolder $serviceHolder): TypeHandler
    {
        return $this->handlerResolver->getHandler($serviceHolder);
    }

}

<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Reflection;

use AwdStudio\DI\Argument\ArgumentResolver;
use AwdStudio\DI\Exception\UnknownServiceType;
use AwdStudio\DI\Reflection\TypeHandler\ConstructorTypeHandler;
use AwdStudio\DI\Reflection\TypeHandler\FactoryTypeHandler;
use AwdStudio\DI\Reflection\TypeHandler\FunctionTypeHandler;
use AwdStudio\DI\Reflection\TypeHandler\TypeHandler;
use AwdStudio\DI\Reflection\TypeHandler\StaticTypeHandler;
use AwdStudio\DI\Storage\ServiceHolder;

final class HandlerResolver
{

    /** @var \AwdStudio\DI\Argument\ArgumentResolver */
    private $argumentsResolver;

    /**
     * HandlerResolver constructor.
     *
     * @param \AwdStudio\DI\Argument\ArgumentResolver $argumentsResolver
     */
    public function __construct(ArgumentResolver $argumentsResolver)
    {
        $this->argumentsResolver = $argumentsResolver;
    }

    /**
     * Resolves which one handler is appropriate for the service-holder.
     *
     * @param \AwdStudio\DI\Storage\ServiceHolder $serviceHolder
     *
     * @return \AwdStudio\DI\Reflection\TypeHandler\TypeHandler
     * @throws \AwdStudio\DI\Exception\UnknownServiceType
     */
    public function getHandler(ServiceHolder $serviceHolder): TypeHandler
    {
        /** @var \AwdStudio\DI\Reflection\TypeHandler\TypeHandler $handler */
        foreach ($this->handlers() as $handler) {
            if ($handler::isAppropriate($serviceHolder)) {
                return new $handler($this->argumentsResolver);
            }
        }

        $message = \sprintf('Cannot get a handler for the service "%s"', $serviceHolder->id());
        throw new UnknownServiceType($message);
    }

    private function handlers(): \Generator
    {
        yield ConstructorTypeHandler::class;
        yield FactoryTypeHandler::class;
        yield StaticTypeHandler::class;
        yield FunctionTypeHandler::class;
    }

}

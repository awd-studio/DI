<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Reflection\TypeHandler;

use AwdStudio\DI\DIContainer;
use AwdStudio\DI\Storage\ServiceHolder;

final class StaticTypeHandler extends TypeHandler
{

    /**
     * {@inheritDoc}
     */
    public static function isAppropriate(ServiceHolder $serviceHolder): bool
    {
        return ServiceHolder::TYPE_STATIC === $serviceHolder->type();
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServiceHolder $serviceHolder, DIContainer $container)
    {
        // TODO: Implement handle() method.
    }

}

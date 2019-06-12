<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Argument;

final class NamedArgument implements Argument
{

    /**
     * {@inheritDoc}
     */
    public static function isAppropriate($argument): bool
    {
        return is_string($argument) && \substr($argument, 0, 1) === '@';
    }

    /**
     * {@inheritDoc}
     */
    public function resolve($argument)
    {
        return \substr($argument, 1);
    }

}

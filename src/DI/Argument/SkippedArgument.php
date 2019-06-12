<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Argument;

final class SkippedArgument implements Argument
{

    /**
     * {@inheritDoc}
     */
    public static function isAppropriate($argument): bool
    {
        return self::SKIP === $argument;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve($argument)
    {
        return null;
    }
}

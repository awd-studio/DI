<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Argument;

interface Argument
{

    /** @var string The value to skip argument */
    const SKIP = '\!skip';

    /**
     * Checks whether the receiver can handle the argument.
     *
     * @param mixed $argument
     *
     * @return bool
     */
    public static function isAppropriate($argument): bool;

    /**
     * Resolves the name of a service.
     *
     * @param mixed $argument
     *
     * @return mixed
     */
    public function resolve($argument);

}

<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Storage;

/**
 * Interface ServiceStorage
 *
 * Uses to store services and find implementations.
 *
 * @package AwdStudio\DI\Storage
 */
interface ServiceStorage
{

    /**
     * Returns the service by it's ID.
     *
     * @param string $id The name of a service.
     *
     * @return \AwdStudio\DI\Storage\ServiceHolder The service holder.
     * @throws \AwdStudio\DI\Exception\ServiceNotDefined
     */
    public function find(string $id): ServiceHolder;

}

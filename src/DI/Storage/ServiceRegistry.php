<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Storage;

interface ServiceRegistry extends \IteratorAggregate
{

    /**
     * Writes down the service definition to the registry.
     *
     * @param string $serviceName The name of a service to add.
     *
     * @return \AwdStudio\DI\Storage\ServiceHolder
     * @throws \AwdStudio\DI\Exception\InvalidServiceDefinition
     */
    public function register(string $serviceName): ServiceHolder;

    /**
     * Loops over through all service-holders in the registry.
     *
     * @return iterable
     */
    public function getIterator();

}

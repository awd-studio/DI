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

    /**
     * Marks a service with a tag.
     *
     * @param string $tag     Tag name.
     * @param string $service Service class.
     * @param int    $weight  Service priority.
     *
     * @return \AwdStudio\DI\Storage\ServiceRegistry
     */
    public function tag(string $tag, string $service, int $weight = 0): self;

    /**
     * Finds services by tag.
     *
     * @param string $tag
     *
     * @return iterable
     */
    public function findByTag(string $tag): iterable;

}

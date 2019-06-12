<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Storage;

use AwdStudio\DI\Argument\ArgumentResolver;
use AwdStudio\DI\Exception\ServiceNotDefined;

final class Storage implements ServiceStorage
{

    /** @var \AwdStudio\DI\Argument\ArgumentResolver */
    private $argumentResolver;

    /** @var \AwdStudio\DI\Storage\ServiceRegistry */
    private $registry;

    /**
     * Storage constructor.
     *
     * @param \AwdStudio\DI\Argument\ArgumentResolver $argumentResolver
     * @param \AwdStudio\DI\Storage\ServiceRegistry   $registry
     */
    public function __construct(ArgumentResolver $argumentResolver, ServiceRegistry $registry)
    {
        $this->argumentResolver = $argumentResolver;
        $this->registry = $registry;
    }

    /**
     * {@inheritDoc}
     */
    public function find(string $id): ServiceHolder
    {
        $serviceName = $this->argumentResolver->resolve($id);

        /** @var \AwdStudio\DI\Storage\ServiceHolder $serviceHolder */
        foreach ($this->registry->getIterator() as $serviceHolder) {
            if ($serviceHolder->isA($serviceName)) {
                return $serviceHolder;
            }
        }

        throw new ServiceNotDefined(\sprintf('The service "%s" was not registered', $id));
    }

}

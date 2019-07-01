<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI;

interface TaggableContainer
{

    /**
     * Resolves services by tag.
     *
     * @param string $tag The tag.
     *
     * @return iterable Service instances.
     * @throws \AwdStudio\DI\Exception\ServiceNotDefined
     * @throws \AwdStudio\DI\Exception\ServiceRunException
     * @throws \AwdStudio\DI\Exception\UnknownServiceType
     */
    public function findByTag(string $tag): iterable;

}

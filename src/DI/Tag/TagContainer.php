<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Tag;

final class TagContainer implements \IteratorAggregate
{

    /** @var string */
    private $tag;

    /** @var array */
    private $services = [];

    /** @var bool */
    private $isSorted = false;

    /**
     * TagContainer constructor.
     *
     * @param string $tag The tag name.
     */
    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        foreach ($this->sorted() as $serviceId => $serviceWeight) {
            yield $serviceId;
        }
    }

    /**
     * Appends the service ID into the collection.
     *
     * @param string $serviceId The ID of a tagged service.
     * @param int    $weight    Service priority.
     *
     * @return \AwdStudio\DI\Tag\TagContainer
     */
    public function add(string $serviceId, int $weight = 0): self
    {
        $this->services[$serviceId] = $weight;
        $this->isSorted = false;

        return $this;
    }

    /**
     * Sorts service collection by the priority if it's not yet.
     *
     * @return iterable
     */
    private function sorted(): iterable
    {
        if (!$this->isSorted) {
            \asort($this->services, SORT_NUMERIC);
        }

        return $this->services;
    }

}

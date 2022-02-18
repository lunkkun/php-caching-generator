<?php

namespace Lunkkun\CachingGenerator;

use Generator;
use OuterIterator;
use ReturnTypeWillChange;

class CachingGenerator implements OuterIterator
{
    /** @var Generator */
    private $generator;
    /** @var array */
    private $cache = [];

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
        $this->addCurrentToCache();
    }

    #[ReturnTypeWillChange]
    public function current()
    {
        return current($this->cache);
    }

    public function next(): void
    {
        if ($this->generator->key() === key($this->cache)) {
            $this->generator->next();
            $this->addCurrentToCache();
        }
        next($this->cache);
    }

    public function key(): int
    {
        return key($this->cache);
    }

    public function valid(): bool
    {
        return key($this->cache) !== null;
    }

    public function rewind(): void
    {
        reset($this->cache);
    }

    public function getInnerIterator(): Generator
    {
        return $this->generator;
    }

    public function getCache(): array
    {
        return $this->cache;
    }

    private function addCurrentToCache(): void
    {
        if ($this->generator->valid()) {
            $this->cache[] = $this->generator->current();
        }
    }
}

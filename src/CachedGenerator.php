<?php

namespace Lunkkun\CachedGenerator;

use Generator;
use OuterIterator;

class CachedGenerator implements OuterIterator
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

    private function addCurrentToCache(): void
    {
        if ($this->generator->valid()) {
            $this->cache[] = $this->generator->current();
        }
    }
}

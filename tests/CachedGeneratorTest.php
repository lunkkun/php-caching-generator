<?php

namespace Lunkkun\CachedGenerator\Tests;

use Lunkkun\CachedGenerator\CachedGenerator;
use PHPUnit\Framework\TestCase;

class CachedGeneratorTest extends TestCase
{
    public function testGenerates()
    {
        $generator = function () {
            foreach (range(0, 2) as $value) {
                yield $value;
            }
        };
        $cachedGenerator = new CachedGenerator($generator());

        $results = iterator_to_array($cachedGenerator);
        $this->assertEquals(range(0, 2), $results);
    }

    public function testWorksWithEmptyGenerator()
    {
        $generator = function () {
            if (false) yield 0;
        };
        $cachedGenerator = new CachedGenerator($generator());

        $results = iterator_to_array($cachedGenerator);
        $this->assertEquals([], $results);
    }

    public function testWorksTwice()
    {
        $generator = function () {
            foreach (range(0, 2) as $value) {
                yield $value;
            }
        };
        $cachedGenerator = new CachedGenerator($generator());

        iterator_to_array($cachedGenerator);

        $results = iterator_to_array($cachedGenerator);
        $this->assertEquals(range(0, 2), $results);
    }

    public function testExposesInnerGenerator()
    {
        $generator = function () {
            foreach (range(0, 2) as $value) {
                yield $value;
            }
        };

        $generatorInstance = $generator();
        $cachedGenerator = new CachedGenerator($generatorInstance);

        $this->assertEquals($generatorInstance, $cachedGenerator->getInnerIterator());
    }

    public function testExposesCache()
    {
        $generator = function () {
            foreach (range(0, 2) as $value) {
                yield $value;
            }
        };
        $cachedGenerator = new CachedGenerator($generator());

        $results = iterator_to_array($cachedGenerator);

        $this->assertEquals($results, $cachedGenerator->getCache());
    }
}

<?php

namespace Lunkkun\CachingGenerator\Tests;

use Lunkkun\CachingGenerator\CachingGenerator;
use PHPUnit\Framework\TestCase;

class CachingGeneratorTest extends TestCase
{
    public function testGenerates()
    {
        $generator = function () {
            foreach (range(0, 2) as $value) {
                yield $value;
            }
        };
        $cachingGenerator = new CachingGenerator($generator());

        $results = iterator_to_array($cachingGenerator);
        $this->assertEquals(range(0, 2), $results);
    }

    public function testWorksWithEmptyGenerator()
    {
        $generator = function () {
            if (false) yield 0;
        };
        $cachingGenerator = new CachingGenerator($generator());

        $results = iterator_to_array($cachingGenerator);
        $this->assertEquals([], $results);
    }

    public function testWorksTwice()
    {
        $generator = function () {
            foreach (range(0, 2) as $value) {
                yield $value;
            }
        };
        $cachingGenerator = new CachingGenerator($generator());

        iterator_to_array($cachingGenerator);

        $results = iterator_to_array($cachingGenerator);
        $this->assertEquals(range(0, 2), $results);
    }

    public function testPicksUpWhereItLeftOff()
    {
        $generator = function () {
            foreach (range(0, 2) as $value) {
                yield $value;
            }
        };
        $cachingGenerator = new CachingGenerator($generator());

        foreach ($cachingGenerator as $value) {
            if ($value === 1) {
                break;
            }
        }

        $results = iterator_to_array($cachingGenerator);
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
        $cachingGenerator = new CachingGenerator($generatorInstance);

        $this->assertEquals($generatorInstance, $cachingGenerator->getInnerIterator());
    }

    public function testExposesCache()
    {
        $generator = function () {
            foreach (range(0, 2) as $value) {
                yield $value;
            }
        };
        $cachingGenerator = new CachingGenerator($generator());

        $results = iterator_to_array($cachingGenerator);

        $this->assertEquals($results, $cachingGenerator->getCache());
    }
}

# Caching Generator for PHP

## Introduction

A PHP Iterator class that you can wrap around a generator to cache its generated values.
When iterating over this class for a second time, values will be pulled from the cache.

If stopped halfway through generating, when iterating for a second time, it will continue generating (and caching) values after exhausting the cache.

## Installation

Require this package with composer using the following command:

```bash
composer require lunkkun/caching-generator
```

## Usage

```php
<?php

use Lunkkun\CachingGenerator\CachingGenerator;

$generator = function () {
    foreach (range(0, 2) as $value) {
        yield $value;
    }
};
$cachingGenerator = new CachingGenerator($generator());

foreach ($cachingGenerator as $value) {
    echo $value;
}

foreach ($cachingGenerator as $value) {
    echo $value;
}
```

Outputs:

```bash
012012
```

## License

PHP Caching Generator is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Cached Generator for PHP

## Introduction

A PHP Iterator class that you can wrap around a generator to cache it's generated values.

## Installation

Require this package with composer using the following command:

```bash
composer require lunkkun/php-cached-generator
```

## Usage

```php
<?php

use Lunkkun\CachedGenerator\CachedGenerator;

$generator = function () {
    foreach (range(0, 2) as $value) {
        yield $value;
    }
};
$cachedGenerator = new CachedGenerator($generator());

foreach ($cachedGenerator as $value) {
    echo $value;
}

foreach ($cachedGenerator as $value) {
    echo $value;
}
```

Outputs:

```bash
012012
```

## License

PHP Cached Generator is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

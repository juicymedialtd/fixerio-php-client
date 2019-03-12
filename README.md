# Fixer.io PHP Client

Simple PHP client for [Fixer.io API](http://fixer.io/)

## Installation

```
$ composer require xotelia/fixerio-php-client
```

## Usage

```php
<?php

putenv('FIXERIO_ACCESS_KEY=YOUR_API_KEY');

require __DIR__.'/vendor/autoload.php';

use FixerIO\FixerIO;

$fixer = new FixerIO();
$rates = $fixer->fetchRates('EUR', ['GBP', 'USD']);
```

## With cache

```php
$cache = new \Doctrine\Common\Cache\FilesystemCache('./cache');

$fixer = new FixerIO($cache, 3600);
$rates = $fixer->fetchRates('EUR', ['GBP', 'USD']);
```


## Fixerio API 

[Fixerio API](https://api.fixer.io/latest) changed how the API works.
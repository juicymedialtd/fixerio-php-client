# Fixer.io PHP Client

Simple PHP client for [Fixer.io API](http://fixer.io/)

## Installation

```
$ composer require xotelia/fixerio-php-client
```

## Usage

```php
<?php

require __DIR__.'/vendor/autoload.php';

use FixerIO\FixerIO;

$fixer = new FixerIO();
$rates = $fixer->rates('EUR', ['GBP', 'USD'])->fetch();
```

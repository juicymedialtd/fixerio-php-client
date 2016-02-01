<?php
require __DIR__.'/vendor/autoload.php';

use FixerIO\FixerIO;

$fixer = new FixerIO();
$rates = $fixer->rates('EUR', ['GBP', 'USD'])->fetch();

var_dump($rate);

<?php

use Codebird\Codebird;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();
$dotenv->required([
    'TWITTER_CONSUMER_KEY',
    'TWITTER_CONSUMER_SECRET',
    'TWITTER_ACCESS_TOKEN',
    'TWITTER_ACCESS_SECRET'
]);

Codebird::setConsumerKey($_ENV['TWITTER_CONSUMER_KEY'], $_ENV['TWITTER_CONSUMER_SECRET']);

$codebird = Codebird::getInstance();

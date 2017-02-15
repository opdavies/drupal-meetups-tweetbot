<?php

use Codebird\Codebird;
use Dotenv\Dotenv;
use Pimple\Container;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();
$dotenv->required([
    'TWITTER_CONSUMER_KEY',
    'TWITTER_CONSUMER_SECRET',
    'TWITTER_ACCESS_TOKEN',
    'TWITTER_ACCESS_SECRET'
]);

$config = require __DIR__ . '/config.php';

$container = new Container();

$container['codebird'] = function () {
    Codebird::setConsumerKey($_ENV['TWITTER_CONSUMER_KEY'], $_ENV['TWITTER_CONSUMER_SECRET']);

    $codebird = Codebird::getInstance();

    $codebird->setToken($_ENV['TWITTER_ACCESS_TOKEN'], $_ENV['TWITTER_ACCESS_SECRET']);

    return $codebird;
};


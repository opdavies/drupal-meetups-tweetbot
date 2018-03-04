<?php

use App\Console\Commands\RunCommand;
use App\Tweets\Fetcher;
use App\Tweets\Tweeter;
use Codebird\Codebird;
use Pimple\Container;
use Symfony\Component\Console\Application;

$container = new Container();

$container['codebird'] = function () {
    Codebird::setConsumerKey($_ENV['TWITTER_CONSUMER_KEY'], $_ENV['TWITTER_CONSUMER_SECRET']);

    $codebird = Codebird::getInstance();

    $codebird->setToken($_ENV['TWITTER_ACCESS_TOKEN'], $_ENV['TWITTER_ACCESS_SECRET']);

    return $codebird;
};

$container['app.config'] = function () {
    return require __DIR__.'/../config.php';
};

$container['app.fetcher'] = function (Container $container) {
    return new Fetcher(
        $container['app.config'],
        $container['codebird']
    );
};

$container['app.tweeter'] = function (Container $container) {
    return new Tweeter($container['codebird']);
};

$container['app.run.command'] = function (Container $container) {
    return new RunCommand(
        $container['app.fetcher'],
        $container['app.tweeter']
    );
};

$container['console'] = function ($container) {
    $application = new Application();

    $application->add($container['app.run.command']);

    return $application;
};

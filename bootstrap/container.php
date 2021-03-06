<?php

use App\Console\Commands\FetchCommand;
use App\Console\Commands\RunCommand;
use App\Tweets\Fetcher;
use App\Tweets\Tweeter;
use Codebird\Codebird;
use Pimple\Container;
use Symfony\Component\Console\Application;

$container = new Container();

$container['codebird'] = function () {
    Codebird::setConsumerKey(
        getenv('TWITTER_CONSUMER_KEY'),
        getenv('TWITTER_CONSUMER_SECRET')
    );

    $codebird = Codebird::getInstance();

    $codebird->setToken(
        getenv('TWITTER_ACCESS_TOKEN'),
        getenv('TWITTER_ACCESS_SECRET')
    );

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

$container['app.fetch.command'] = function (Container $container) {
    return new FetchCommand($container['app.fetcher']);
};

$container['app.run.command'] = function (Container $container) {
    return new RunCommand(
        $container['app.fetcher'],
        $container['app.tweeter']
    );
};

$container['console'] = function ($container) {
    $application = new Application();

    $application->add($container['app.fetch.command']);
    $application->add($container['app.run.command']);

    return $application;
};

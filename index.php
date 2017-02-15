<?php

require 'bootstrap/app.php';

$params = [];

$params[] = implode(array_map(function ($account) {
    return "from:{$account}";
}, $config['accounts']), ' OR ');

$params[] = implode($config['hashtags'], ' OR ');

$results = (array) $container['codebird']->search_tweets([
    'q' => implode($params, ' AND '),
]);

if (empty($results['statuses'])) {
    return;
}

foreach ($results['statuses'] as $status) {
    $container['codebird']->statuses_retweet_ID(['id' => $status->id]);
}

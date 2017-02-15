<?php

require 'bootstrap/app.php';

$params = [];

$params[] = implode(array_map(function ($account) {
    return "from:{$account}";
}, $config['accounts']), ' OR ');

$params[] = implode($config['hashtags'], ' OR ');

$response = (array) $container['codebird']->search_tweets([
    'q' => implode($params, ' AND '),
]);

if ($response['httpstatus'] != 200) {
    return;
}

if (empty($response['statuses'])) {
    return;
}

foreach ($response['statuses'] as $status) {
    $container['codebird']->statuses_retweet_ID(['id' => $status->id]);
}

<?php

require 'bootstrap/app.php';

$params = [
    '#drupalmeetups',
    '#drupalmeetup'
];

$results = (array) $container['codebird']->search_tweets([
    'q' => implode($params, ' OR '),
]);

if (empty($results['statuses'])) {
    return;
}

foreach ($results['statuses'] as $status) {
    $container['codebird']->statuses_retweet_ID(['id' => $status->id]);
}

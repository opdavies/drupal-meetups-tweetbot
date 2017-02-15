<?php

require 'bootstrap/app.php';

$results = (array) $container['codebird']->search_tweets([
    'q' => 'drupalmeetups'
]);

if (empty($results['statuses'])) {
    return;
}

foreach ($results['statuses'] as $status) {
    $container['codebird']->statuses_retweet_ID(['id' => $status->id]);
}

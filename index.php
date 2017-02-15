<?php

require 'bootstrap/app.php';

$params = [];

$params[] = implode(array_map(function ($account) {
    return "from:{$account}";
}, $config['accounts']), ' OR ');

$params[] = implode($config['hashtags'], ' OR ');

$last_tweet_id = false;
if (file_exists('last_tweet_id')) {
    $last_tweet_id = file_get_contents('last_tweet_id');
}

$response = (array) $container['codebird']->search_tweets([
    'q' => implode($params, ' AND '),
    'since_id' => $last_tweet_id,
]);

if ($response['httpstatus'] != 200) {
    return;
}

if (empty($response['statuses'])) {
    return;
}

foreach (array_reverse($response['statuses']) as $status) {
    $container['codebird']->statuses_retweet_ID(['id' => $status->id]);

    file_put_contents('last_tweet_id', $status->id);
}

<?php

require 'bootstrap/app.php';

$codebird->setToken($_ENV['TWITTER_ACCESS_TOKEN'], $_ENV['TWITTER_ACCESS_SECRET']);

$reply = (array) $codebird->statuses_homeTimeline();
var_dump($reply);

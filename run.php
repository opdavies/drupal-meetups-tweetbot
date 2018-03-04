<?php

use Symfony\Component\Console\Application;

require_once __DIR__.'/bootstrap/app.php';
require_once __DIR__.'/bootstrap/container.php';

/** @var Application $application */
$application = $container['console'];
$application->run();

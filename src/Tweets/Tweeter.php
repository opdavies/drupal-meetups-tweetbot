<?php

namespace App\Tweets;

use Codebird\Codebird;
use stdClass;

class Tweeter
{
    /**
     * @var \Codebird\Codebird
     */
    private $codebird;

    public function __construct(Codebird $codebird)
    {
        $this->codebird = $codebird;
    }

    public function retweet(stdClass $tweet)
    {
        $this->codebird->statuses_retweet_ID(['id' => $tweet->id]);
    }
}

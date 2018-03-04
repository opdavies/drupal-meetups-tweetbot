<?php

namespace App\Tests\Tweets;

class Fetcher extends \App\Tweets\Fetcher
{
    /**
     * @return array
     */
    public function getParams() {
        $this->buildParams();

        return $this->params;
    }
}

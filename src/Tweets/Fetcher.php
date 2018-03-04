<?php

namespace App\Tweets;

use Codebird\Codebird;
use Tightenco\Collect\Support\Collection;

class Fetcher
{
    const FILENAME = 'last_tweet_id.txt';

    private $config = [];

    private $codebird;

    private $params = [];

    private $statuses = [];

    private $lastTweetId;

    /**
     * Fetcher constructor.
     *
     * @param array $config
     * @param \Codebird\Codebird $codebird
     */
    public function __construct(array $config, Codebird $codebird)
    {
        $this->config = $config;
        $this->codebird = $codebird;
    }

  /**
   * Return any relevant tweets.
   *
   * @return Collection
   */
  public function fetch()
    {
        $this->buildParams()
            ->getLastTweetId()
            ->getTweets()
            ->setLastTweet();

        return collect($this->statuses);
    }

    private function buildParams()
    {
        $this->params[] = collect($this->config['accounts'])
            ->map(function (string $account) {
                return "from:{$account}";
            })
            ->implode(' OR ');


        $this->params[] = collect($this->config['hashtags'])
            ->map(function (string $hashtag) {
                return "#{$hashtag}";
            })
            ->implode(' OR ');

        return $this;
    }

    private function getLastTweetId()
    {
        if (file_exists(self::FILENAME)) {
            $this->lastTweetId = file_get_contents(self::FILENAME);
        }

        return $this;
    }

    private function getTweets()
    {
        $response = collect($this->codebird->search_tweets([
            'q' => collect($this->params)->implode(' AND '),
            'since_id' => $this->lastTweetId,
        ]));

        if ($response->get('httpstatus') !== 200) {
            $this->statuses = [];
        }

        $this->statuses = $response->get('statuses');

        return $this;
    }

    private function setLastTweet()
    {
        file_put_contents(
            self::FILENAME,
            collect($this->statuses)->pluck('id')->last()
        );
    }
}

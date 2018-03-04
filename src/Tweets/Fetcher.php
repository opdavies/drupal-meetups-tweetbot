<?php

namespace App\Tweets;

use Codebird\Codebird;
use stdClass;
use Tightenco\Collect\Support\Collection;

class Fetcher
{
    const FILENAME = 'last_tweet_id.txt';

    private $config = [];

    private $codebird;

    private $params = [];

    /**
     * @var Collection
     */
    private $statuses;

    private $lastTweetId = false;

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
        $this->statuses = collect();
    }

    /**
     * Return any relevant tweets.
     *
     * @param bool $updateLastId
     *
     * @return \Tightenco\Collect\Support\Collection
     */
    public function fetch($updateLastId = true)
    {
        $this->buildParams()
            ->getLastTweetId()
            ->getTweets();

        if ($updateLastId) {
            $this->setLastTweet();
        }

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

        if ($response->get('httpstatus') == 200) {
            $this->statuses = collect($response->get('statuses'))
                ->map(function (stdClass $tweet) {
                    return (object) [
                        'id' => $tweet->id,
                        'created' => strtotime($tweet->created_at),
                        'text' => $tweet->text,
                        'author' => $tweet->user->screen_name,
                    ];
                })
                ->reverse();
        }

        return $this;
    }

    private function setLastTweet()
    {
        if ($this->statuses->isEmpty()) {
          return;
        }

        file_put_contents(
            self::FILENAME,
            $this->statuses->pluck('id')->last()
        );
    }
}

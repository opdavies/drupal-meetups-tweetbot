<?php

namespace App\Console\Commands;

use App\Tweets\Fetcher;
use App\Tweets\Tweeter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCommand extends Command
{
    /**
     * @var \App\Tweets\Fetcher
     */
    private $fetcher;

    /**
     * @var \App\Tweets\Tweeter
     */
    private $tweeter;

  /**
   * RunCommand constructor.
   *
   * @param \App\Tweets\Fetcher $fetcher
   */
    public function __construct(Fetcher $fetcher, Tweeter $tweeter)
    {
        parent::__construct();

        $this->fetcher = $fetcher;
        $this->tweeter = $tweeter;
    }

    protected function configure()
    {
        $this->setName('run')
            ->setDescription('Fetches and processes tweets.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->fetcher->fetch() as $tweet) {
            $this->tweeter->retweet($tweet);
        }
    }
}

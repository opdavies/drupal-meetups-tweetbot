<?php

namespace App\Console\Commands;

use App\Tweets\Fetcher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchCommand extends Command
{
    /**
     * @var \App\Tweets\Fetcher
     */
    private $fetcher;

  /**
   * RunCommand constructor.
   *
   * @param \App\Tweets\Fetcher $fetcher
   */
    public function __construct(Fetcher $fetcher)
    {
        parent::__construct();

        $this->fetcher = $fetcher;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('fetch')
            ->setDescription('Fetches tweets and displays them in a table.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders(['From', 'Tweet ID', 'Text', 'When']);

        foreach ($this->fetcher->fetch(false) as $tweet) {
          $table->addRow([
              $tweet->author,
              $tweet->id,
              $tweet->text,
              $tweet->created,
          ]);
        }

        $table->render();
    }
}

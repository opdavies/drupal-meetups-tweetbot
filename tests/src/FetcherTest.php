<?php

namespace App\Tests;

use App\Tests\Tweets\Fetcher;
use Codebird\Codebird;
use PHPUnit\Framework\TestCase;

class FetcherTest extends TestCase
{
    /**
     * @var Fetcher
     */
    private $fetcher;

    public function setUp() {
        $config = [
            'accounts' => ['opdavies', 'drupalbristol'],
            'hashtags' => ['foo', 'bar', 'baz'],
        ];

        $codebird = $this->getMockBuilder(Codebird::class)->getMock();

        $this->fetcher = new Fetcher($config, $codebird);
    }

    public function testParameterStringsAreBuildCorrectly() {
        $params = $this->fetcher->getParams();

        $this->assertSame('from:opdavies OR from:drupalbristol', $params[0]);
        $this->assertSame('#foo OR #bar OR #baz', $params[1]);
    }
}

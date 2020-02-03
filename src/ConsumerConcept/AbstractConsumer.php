<?php

declare(strict_types=1);

namespace SwooleResearch\ConsumerConcept;

use GuzzleHttp\DefaultHandler;
use Swoole\Coroutine;
use Swoole\Coroutine\Scheduler;
use Yurun\Util\Swoole\Guzzle\SwooleHandler;

abstract class AbstractConsumer
{
    public static $messages = [];

    private $processing = false;

    public function handle(): void
    {
        // configure GuzzleClient to work on Swoole
        DefaultHandler::setDefaultHandler(SwooleHandler::class);
        $scheduler = new Scheduler();

        foreach (self::$messages as $message) {
            echo 'Message ID: ' . $message['data']['id'];
            echo PHP_EOL;

            $this->processing = true;
            $scheduler->add(function () use ($message) {
                $this->process($message);
                $this->processing = false;
            });
            $scheduler->add(function () {
                $this->ping();
            });

            $scheduler->start();

            echo PHP_EOL;
        }
    }

    abstract protected function process(array $message): void;

    private function ping(): void
    {
        while ($this->processing) {
            echo 'ping';
            echo PHP_EOL;
            Coroutine::sleep(1);
        }
    }
}

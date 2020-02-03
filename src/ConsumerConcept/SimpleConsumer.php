<?php

declare(strict_types=1);

namespace SwooleResearch\ConsumerConcept;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Swoole\Coroutine;

class SimpleConsumer extends AbstractConsumer
{
    protected function process(array $message): void
    {
        $messageID = $message['data']['id'];
        $sleepTime = $message['data']['attributes']['sleep_time'];

        echo "Message #$messageID: DB queries";
        echo PHP_EOL;
        Coroutine::sleep(0.001);

        echo "Message #$messageID: PHP Code";
        echo PHP_EOL;
        // this line releases execution thread to execute another operation
        // it should be used in the PHP code to let the ping() method be exectuted
        Coroutine::sleep(0.001);

        // client is configured to work asynchronously via Swoole HTTP client
        // so there is no need to call Coroutine::sleep()
        $client = new Client(['base_uri' => 'http://127.0.0.1:9501']);
        echo "Message #$messageID: Internal API request 1";
        echo PHP_EOL;
        $response = $client->get("sleep/$sleepTime");
        echo "Message #$messageID: Response 2: " . $response->getBody()->getContents();
        echo PHP_EOL;

        echo "Message #$messageID: Internal API request 2";
        echo PHP_EOL;
        $response = $client->get("sleep/$sleepTime");
        echo "Message #$messageID: Response 2: " . $response->getBody()->getContents();
        echo PHP_EOL;

        echo "Message #$messageID: Internal API async requests";
        echo PHP_EOL;
        // pay attention to this request, it's really async now
        // without calling wait() this request ends after the method is executed
        $client->getAsync("sleep/$sleepTime")->then(function (ResponseInterface $response) use ($messageID) {
            echo "Message #$messageID: Response async: " . $response->getBody()->getContents();
            echo PHP_EOL;
        })->wait();

        echo "Message #$messageID: finish processing message with ID: " . $message['data']['id'];
        echo PHP_EOL;
    }
}

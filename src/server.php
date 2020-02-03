<?php
$http = new Swoole\HTTP\Server("0.0.0.0", 9501);

$http->on('start', function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on('request', static function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
    $path = explode('/', trim($request->server['path_info'], '/'));

    if ($path[0] === 'sleep') {
        sleep((int)$path[1]);
    }

    $response->header('Content-Type', 'text/plain');
    $response->end('Hello world');
});

$http->start();

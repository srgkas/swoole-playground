# Swoole example

## Build & run
1. `docker build ./ -t swoole-playground`
2. `docker run --rm -p 9501:9501 swoole-playground --name swoole src/server.php`
3. `docker exec swoole src/consume.php`

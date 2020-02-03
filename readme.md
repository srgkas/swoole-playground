# Swoole example

## Build & run
1. `docker build ./ -t swoole-playground`
2. `docker run --rm -p 9501:9501 -v $(pwd)/src:/app -w /app swoole-playground server.php`
3. 

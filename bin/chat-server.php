<?php

use App\Chat\Chat;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat($container)
        )
    ),
    84
);

$server->run();
<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Predis\Client as PRedis;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function time;

class PingHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $predis = new PRedis(
            [
                'scheme' => 'tcp',
                'host'   => 'redis',
                'port'   => 6379,
            ]
        );

        /*$predis->set('chatId.1:userId.roman', 'my message');
        $value = $predis->get('chatId.1');
        $value2 = $predis->get('chatId.1:userId.roman');*/


        $predis->zadd('chat', ['message1' => 1]);
        $predis->zadd('chat', ['message3' => 3]);
        $predis->zadd('chat', ['message2' => 2]);

        $value2 = $predis->zrange('chat', 0, -1);

        dd($value2);

        return new JsonResponse(['ack' => time()]);
    }
}

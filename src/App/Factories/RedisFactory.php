<?php


namespace App\Factories;


use Predis\Client;
use Psr\Container\ContainerInterface;

class RedisFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $redis = $config['redis_config'];

        return new Client($redis);
    }
}

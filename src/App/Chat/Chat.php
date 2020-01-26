<?php

namespace App\Chat;

use App\Chat\Actions\ActionInterface;
use App\Chat\Actions\Connection;
use App\Chat\Actions\Message;
use Predis\Client;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    public $clients;
    /**
     * @var Client
     */
    public $predis;

    public $actions = [
        'connection' => Connection::class,
        'message' => Message::class,
    ];
    /**
     * @var ConnectionInterface
     */
    public $from;

    public function __construct($container)
    {
        $this->clients = new \SplObjectStorage;
        $this->predis = $container->get('App\Factories\RedisFactory');
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $this->from = $from;

        $messageHandler = new MessageResolver($msg);

        /** @var ActionInterface $action */
        $action = new $this->actions[$messageHandler->getAction()];
        $action->setChat($this);
        $action->run($messageHandler);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
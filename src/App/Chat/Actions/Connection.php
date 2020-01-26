<?php


namespace App\Chat\Actions;


class Connection extends AbstractAction
{
    public function run($messageHandler)
    {
        $lrange = $this->chat->predis->lrange('chat:'.$messageHandler->getChatId(), 0, -1);
        if (!empty($lrange)) {
            $messages = [];
            foreach ($lrange as $item) {
                array_unshift($messages, json_decode($item, true));
            }
            $response = $messages;
        }

        foreach ($this->chat->clients as $client) {
            if ($this->chat->from === $client) {
                $client->send(json_encode($response));
            }
        }
    }
}

<?php


namespace App\Chat\Actions;


class Message extends AbstractAction
{
    public function run($messageHandler)
    {
        $msgData = [
            'user' => $messageHandler->getUser(),
            'time' => date('Y-m-d H:i:s'),
            'message' => $messageHandler->getMessage(),
        ];

        $result = $this->chat->predis->lpush('chat:'.$messageHandler->getChatId(), [json_encode($msgData)]);
        if ($result > 0) {
            $response = [$msgData];
        }

        foreach ($this->chat->clients as $client) {
            if ($this->chat->from !== $client || 1) {
                $client->send(json_encode($response));
            }
        }
    }
}

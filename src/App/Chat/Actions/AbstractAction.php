<?php


namespace App\Chat\Actions;


abstract class AbstractAction implements ActionInterface
{
    protected $chat;

    public function setChat($chat)
    {
        $this->chat = $chat;
    }

}
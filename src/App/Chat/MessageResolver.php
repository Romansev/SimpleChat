<?php


namespace App\Chat;


class MessageResolver
{
    private $action;
    private $chatId;
    private $user;
    private $message;

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getChatId()
    {
        return $this->chatId;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * MessageHandler constructor.
     *
     * @throws ChatException
     */
    public function __construct($message)
    {
        $message = json_decode($message, true);

        if (!array_key_exists('action', $message)) {
            throw new ChatException('Invalid Action');
        }

        if (!array_key_exists('chatId', $message)) {
            throw new ChatException('Invalid Chat Id');
        }

        if (!array_key_exists('userId', $message)) {
            throw new ChatException('userId');
        }

        $this->action = $message['action'];
        $this->chatId = $message['chatId'];
        $this->user = $message['userId'];

        if (array_key_exists('message', $message)) {
            $this->message = $message['message'];
        }
    }
}
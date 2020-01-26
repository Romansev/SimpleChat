<?php


namespace App\Chat\Actions;


interface ActionInterface
{
    public function setChat($chat);

    public function run($messageHandler);
}
<?php

declare(strict_types=1);

namespace App\Handler\Chat;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class ChatFactory
{
    public function __invoke(ContainerInterface $container) : Chat
    {
        return new Chat($container->get(TemplateRendererInterface::class));
    }
}

<?php

declare(strict_types=1);

namespace Src;

use Psr\EventDispatcher\EventDispatcherInterface;

class AsyncEventDispatcher implements EventDispatcherInterface
{
    public function __construct(private readonly Queue $queue) {}

    public function dispatch(object $event): void
    {
        $this->queue->enqueue('users_registered.send_welcome_email', $event);
    }
}

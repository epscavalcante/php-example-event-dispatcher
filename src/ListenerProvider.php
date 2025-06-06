<?php

declare(strict_types=1);

namespace Src;

use Psr\EventDispatcher\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{
    private array $listeners = [];

    public function addListener(string $eventClass, callable $listener): void
    {
        $this->listeners[$eventClass][] = $listener;
    }

    public function getListenersForEvent(object $event): iterable
    {
        $class = get_class($event);
        return $this->listeners[$class] ?? [];
    }
}

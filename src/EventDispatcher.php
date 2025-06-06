<?php

declare(strict_types=1);

namespace Src;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(private ListenerProviderInterface $provider) {}

    public function dispatch(object $event): object
    {
        foreach ($this->provider->getListenersForEvent($event) as $listener) {
            $listener($event);
        }
        return $event;
    }
}

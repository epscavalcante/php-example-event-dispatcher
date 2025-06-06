<?php

declare(strict_types=1);

use Src\AsyncEventDispatcher;
use Src\SyncEventDispatcher;
use Src\Events\UserRegisteredEvent;
use Src\ListenerProvider;
use Src\Listeners\SendWelcomeEmailListener;
use Src\RabbitMQQueue;
use Src\InMemoryQueue;

require_once __DIR__ . '/../vendor/autoload.php';

$listerProvider = new ListenerProvider();
$listerProvider->addListener(UserRegisteredEvent::class, new SendWelcomeEmailListener);

$eventDispatcher = new SyncEventDispatcher(
    provider: $listerProvider
);

//$queue = new InMemoryQueue;
$queue = new RabbitMQQueue;
$eventDispatcher = new AsyncEventDispatcher(
    queue: $queue
);

$eventDispatcher->dispatch(
    event: new UserRegisteredEvent(
        email: 'john.doe@email.com'
    )
);

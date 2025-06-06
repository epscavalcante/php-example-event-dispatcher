<?php

declare(strict_types=1);

use Src\EventDispatcher;
use Src\Events\UserRegisteredEvent;
use Src\ListenerProvider;
use Src\Listeners\SendWelcomeEmailListener;

require_once __DIR__ . '/../vendor/autoload.php';

$listerProvider = new ListenerProvider();
$listerProvider->addListener(UserRegisteredEvent::class, new SendWelcomeEmailListener);

$eventDispatcher = new EventDispatcher(
    provider: $listerProvider
);

$eventDispatcher->dispatch(
    event: new UserRegisteredEvent(
        email: 'john.doe@email.com'
    )
);

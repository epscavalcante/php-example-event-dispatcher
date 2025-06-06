<?php

declare(strict_types=1);

namespace Src\Listeners;

use Src\Events\UserRegisteredEvent;

class SendWelcomeEmailListener
{
    public function __invoke(UserRegisteredEvent $event): void
    {
        echo "📧 Enviando e-mail para: {$event->email}\n";
    }
}

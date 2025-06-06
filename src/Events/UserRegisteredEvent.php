<?php

declare(strict_types=1);

namespace Src\Events;

class UserRegisteredEvent
{
    public function __construct(public readonly string $email) {}
}

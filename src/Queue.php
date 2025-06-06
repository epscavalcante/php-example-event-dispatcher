<?php

declare(strict_types=1);

namespace Src;

interface Queue
{
    public function enqueue(string $queue, object $data): void;
}
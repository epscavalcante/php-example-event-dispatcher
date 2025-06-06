<?php

declare(strict_types=1);

namespace Src;

class InMemoryQueue implements Queue
{
    private array $queue = [];

    public function enqueue(string $queue, object $data): void
    {
        echo "Adicionando na fila {$queue}" . PHP_EOL;

        $this->queue[$queue][] = $data;
    }
}

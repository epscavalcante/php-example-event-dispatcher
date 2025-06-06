<?php

declare(strict_types=1);

namespace Src;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Src\Queue;

class RabbitMQQueue implements Queue
{
    private $channel;

    public function __construct()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'admin', 'password');
        $this->channel = $connection->channel();
    }

    public function enqueue(string $queue, object $data): void
    {
        $payload = json_encode([
            //'event_class' => get_class($event),
            //'data' => get_object_vars($event),
            'data' => get_object_vars($data)
        ]);

        $this->channel->queue_declare($queue, false, true, false, false);

        $msg = new AMQPMessage($payload, ['delivery_mode' => 2]);
        $this->channel->basic_publish($msg, '', $queue);

        echo "[RabbitMQ] Evento enviado para a fila: {$queue}\n";
    }
}

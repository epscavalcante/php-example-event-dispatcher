<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Src\Events\UserRegisteredEvent;
use Src\ListenerProvider;
use Src\Listeners\SendWelcomeEmailListener;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'admin', 'password');
$channel = $connection->channel();
$queueName = 'users_registered.send_welcome_email';

$channel->queue_declare($queueName, false, true, false, false);

$provider = new ListenerProvider();
$provider->addListener(UserRegisteredEvent::class, new SendWelcomeEmailListener());

echo "[RabbitMQ] Esperando eventos...\n";

$channel->basic_consume($queueName, '', false, true, false, false, function ($msg) use ($provider) {

    $data = json_decode($msg->body, true);

    echo "Processando mensagem: " . json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;
    /*
    $eventClass = $data['event_class'];
    $eventData = $data['data'] ?? [];

    if (class_exists($eventClass)) {
        $event = new $eventClass(...array_values($eventData));

        foreach ($provider->getListenersForEvent($event) as $listener) {
            $listener($event);
        }
    }
    */
});

while ($channel->is_consuming()) {
    $channel->wait();
}

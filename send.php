<?php 
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$counter = 0;
while ($counter <= 300) {
	sleep(2);
	$channel->queue_declare('hello', false, false, false, false);

	$msg = new AMQPMessage('Hello World!');
	$channel->basic_publish($msg, '', 'hello');

	echo " [x] Sent 'Hello World!'\n" . $counter;
	$counter = $counter + 1;
}

$channel->close();
$connection->close();

?>
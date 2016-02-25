<?php
/**
 * Queue test task using RabbitMQ
 */

require_once "config.php";
require_once "InterestCalculation.php";
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
$channel = $connection->channel();
$channel->queue_declare('', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg) {
    global $channel;
    $received = json_decode($msg->body);

    $loanData = new InterestCalculation($received->sum, $received->days);
    $loanData->calculateInterest();

    $data = json_encode(
        array(
            "sum" => $loanData->sum,
            "days" => $loanData->days,
            "interest" => $loanData->interest,
            "totalSum" => $loanData->interest + $received->sum,
            "token" => "porsh",
        )
    );

    $msg = new AMQPMessage($data, array('content_type' => 'text/json', 'delivery_mode' => 2));
    $channel->basic_publish($msg, '', 'solved-interest-queue');

    //$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};


$channel->basic_consume('interest-queue', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
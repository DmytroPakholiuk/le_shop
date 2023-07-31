<?php

namespace common\models;


use Enqueue\AmqpLib\AmqpContext;
use Interop\Amqp\Impl\AmqpMessage;
use Interop\Queue\Consumer;
use Interop\Queue\Context;
use Interop\Queue\Message as MessageInterface;
use PhpAmqpLib\Message\AMQPMessage as LibAMQPMessage;

class RabbitMessage extends \yii\base\Model
{
    /**
     * @var string text content of message
     */
    private string $content = '';

    /**
     * @var string exchange to post this message into
     */
    private string $exchange = '';

    /**
     * @var string routing key of this message
     */
    private string $routingKey = '';

    /**
     * @var Consumer consumer that received this message (if message was received from queue)
     */
    private Consumer $consumer;

    /**
     * @var AmqpContext|Context
     */
    private AmqpContext|Context $context;

    /**
     * @var LibAMQPMessage the actual message this model is operating if it was just created
     */
    private LibAMQPMessage $newMessage;

    /**
     * @var MessageInterface the message model if it was received from queue
     */
    private MessageInterface $receivedMessage;

    /**
     * @var bool Marks this message if it was created or received from queue
     */
    private bool $isNew = true;

    public function isNew(): bool
    {
        return $this->isNew;
    }

    public function setContent($content): RabbitMessage
    {
        if (is_array($content) || is_object($content)){
            $content = json_encode($content);
        }
        $this->content = $content;
        $this->newMessage->setBody($content);
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setExchange($exchange): RabbitMessage
    {
        $this->exchange = $exchange;
        return $this;
    }

    public function getExchange(): string
    {
        return $this->exchange;
    }

    public function setRoutingKey($key): RabbitMessage
    {
        $this->routingKey = $key;
        return $this;
    }

    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }

    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }

    public function getMessage(): MessageInterface|LibAMQPMessage|null
    {
        if ($this->isNew()){
            return $this->newMessage;
        } else {
            return $this->receivedMessage;
        }
    }

    public function publish()
    {
//        $this->context->createProducer()->send(, $this->message);
        $this->context->getLibChannel()->basic_publish(
            $this->newMessage,
            $this->exchange,
            $this->routingKey
        );
    }

    public function ack()
    {
        if (!$this->isNew){
            $this->getConsumer()->acknowledge($this->receivedMessage);
        }
    }

    public function __construct(Context $context, Consumer $consumer = null, $config = [])
    {
        $this->context = $context;
        if ($consumer === null){
            $this->newMessage = new LibAMQPMessage();
        } else {
            $this->consumer = $consumer;
            $this->isNew = false;
            $this->receivedMessage = $consumer->receive();
            $this->content = $this->receivedMessage->getBody();
        }

        parent::__construct($config);
    }
}

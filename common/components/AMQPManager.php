<?php

namespace common\components;
use common\models\RabbitMessage;
use Enqueue\AmqpLib\AmqpConnectionFactory;
use Enqueue\AmqpLib\AmqpContext;
use Interop\Queue\Consumer;

class AMQPManager extends \yii\base\Component
{
    private AmqpConnectionFactory $connection;
    private AmqpContext $context;
    private array $consumers = [];

    public function getConnectionFactory(): AmqpConnectionFactory
    {
        return $this->connection;
    }

    public function getContext(): AmqpContext
    {
        return $this->context;
    }

    public function getVHost(): string
    {
        return $this->connection->getConfig()->getVHost();
    }

    public function getHost(): string
    {
        return $this->connection->getConfig()->getHost();
    }

    public function getUser(): string
    {
        return $this->connection->getConfig()->getUser();
    }

    public function getPass(): string
    {
        return $this->connection->getConfig()->getPass();
    }

    public function getPort(): string
    {
        return $this->connection->getConfig()->getPort();
    }

    public function __construct($config = [])
    {
        $this->connection = new AmqpConnectionFactory($config);
        $this->context = $this->connection->createContext();

        parent::__construct();
    }

    public function createMessage(): RabbitMessage
    {
        return new RabbitMessage($this->context);
    }

    public function receiveMessageFrom(string $queue = ''): RabbitMessage
    {
        if (!array_key_exists($queue, $this->consumers)){
            $this->registerConsumer($queue);
        }
        $consumer = $this->consumers[$queue];
//        $message = $consumer->receive();
        return new RabbitMessage($this->context, $consumer);
//        return new RabbitMessage($this->context, $queue);
    }

    private function registerConsumer(string $queueName)
    {
        $queue = $this->context->createQueue($queueName);
        $this->consumers[$queueName] = $this->context->createConsumer($queue);
    }


}
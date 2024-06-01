<?php

namespace console\controllers;

use common\components\AMQPManager;
use Enqueue\AmqpLib\AmqpConnectionFactory;
use Interop\Amqp\AmqpTopic;
use PhpAmqpLib\Message\AMQPMessage;
use yii\console\Controller;

class CommandController extends Controller
{
    public function actionPublish()
    {
        $connection = new AmqpConnectionFactory(
            [
                'host' => 'localhost',
                'port' => 5672,
                'user' => 'guest',
                'pass' => 'guest',
                'vhost' => '/'
            ]
        );
        $context = $connection->createContext();
        $message = ['test'=>'aaa'];
        $amqpMsg = new AMQPMessage(json_encode($message));

        $context->getLibChannel()->basic_publish($amqpMsg, 'firsrt_test', 'aaa');
    }

    public function actionConsume()
    {
        $connection = new AmqpConnectionFactory(
            [
                'host' => 'localhost',
                'port' => 5672,
                'user' => 'guest',
                'pass' => 'guest',
                'vhost' => '/'
            ]
        );
        $context = $connection->createContext();

        $queue = $context->createQueue('second');
        $consumer = $context->createConsumer($queue);

        $msg = $consumer->receive();

        var_dump($msg->getBody());

        $consumer->acknowledge($msg);

    }

    public function actionNewPublish()
    {
        /**
         * @var AMQPManager $manager
         */
        $manager = \Yii::$app->get('rabbit');
//        var_dump($manager);
        $message = $manager->createMessage();
        $message->setContent(['test' => 'one'])
            ->setRoutingKey('aaa')
            ->setExchange('firsrt_test')
            ->publish();

    }

    public function actionNewConsume()
    {
        /**
         * @var AMQPManager $manager
         */
        $manager = \Yii::$app->get('rabbit');

        $message = $manager->receiveMessageFrom('first_queue');
        var_dump($message->getContent());
        $message->ack();
    }

    public function actionTest() {
        \Yii::$app->redis->set('mykey', 'some value');
        echo \Yii::$app->redis->get('mykey');
    }

}
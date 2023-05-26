<?php

namespace console\controllers;

use aki\telegram\Telegram;
use common\models\TelegramVoiceModel;

class TelegramBotController extends \yii\console\Controller
{
    public function actionRun(){
        $telegram = \Yii::$app->get('telegram');
        $model = new TelegramVoiceModel($telegram);

//        var_dump($model->telegram->apiUrl);die();

        $model->getUpdates();
        $model->respondToUpdates();
//        var_dump($model->update);
    }
}
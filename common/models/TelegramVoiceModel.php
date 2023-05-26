<?php

namespace common\models;

use aki\telegram\Telegram;
use aki\telegram\types\File;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use yii\base\Model;
use yii\helpers\FileHelper;

class TelegramVoiceModel extends Model
{
    public Telegram $telegram;
    public Client $client;
    public Response $response;

    public File $voice;

    public array $update= [];

    public function __construct(Telegram $telegram, $config = [])
    {
        $this->telegram = $telegram;
        $this->client = new Client();
        parent::__construct($config);
    }

    public function getUpdates()
    {
        $this->update = $this->telegram->getUpdates();
    }


    public function respondToUpdates()
    {
        foreach ($this->update['result'] as $result){
            if (isset($result['message']['voice'])){
                $file_id = $result['message']['voice']['file_id'];
                $text = $this->telegram->send('/getFile', [
                     'file_id' => $file_id,
                     ]);
                $filePath = $text['result']['file_path'];
//                var_dump($text);

                FileHelper::createDirectory('voices');

                $voiceRecord = TelegramVoiceMessage::find()->where(['file_id' => $file_id])->one();
                if ($voiceRecord === null){
                    $voiceRecord = new TelegramVoiceMessage();

                    $voiceRecord->chat_id = $result['message']['chat']['id'];
                    $voiceRecord->user_id = $result['message']['from']['id'];
                    $voiceRecord->file_id = $file_id;
                    $voiceRecord->file_size = $result['message']['voice']['file_size'];
                    $voiceRecord->save();

                    $localFilePath = "voices/voice-{$voiceRecord->id}.ogx";
                    $this->response = $this->client->request('GET',
                        $this->telegram->apiUrl."/file/bot".$this->telegram->botToken."/".$filePath,
                        ['sink' => $localFilePath]);

                    $revAi = new RevAiClient(\Yii::$app->params['revAiToken']);

                    $jobSubmissionResponse = $revAi->submitAsychronousJobLocal($localFilePath);

// get the job ID and status
                    $jobId = $jobSubmissionResponse->id;
                    $jobStatus = $jobSubmissionResponse->status;
                    echo "Job submitted with id: $jobId" . PHP_EOL;

// check the job status periodically
                    while ($jobStatus == 'in_progress') {
                        $jobStatus = $revAi->getAsychronousJobStatus($jobId)->status;
                        echo "Job status: $jobStatus" . PHP_EOL;
                        sleep(30);
                    }

                    $resultText = '';
                    $resultArray = [];
// retrieve and print the transcript
                    if ($jobStatus == 'transcribed') {
                        $resultArray = $revAi->getAsychronousJobResult($jobId);
                        var_dump($resultArray);

                        foreach ($resultArray->monologues as $monologue) {
                            $resultText .= '- ';
                            foreach ($monologue->elements as $element){
                                $resultText .= $element->value;
                            }
                            $resultText .= "\n";
                        }
                    }
                    var_dump($resultText);
                    $voiceRecord->text = $resultText;
                    $voiceRecord->save();

                    $this->telegram->sendMessage([
                        'chat_id' => $voiceRecord->chat_id,
                        'text' => $resultText
                    ]);
                }
            }
        }
    }
}
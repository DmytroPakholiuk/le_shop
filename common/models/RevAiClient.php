<?php

namespace common\models;

use Exception;
use GuzzleHttp\Client;
use stdClass;

class RevAiClient extends \yii\base\Model
{
    /**
     * @var $client GuzzleHttp client object
     *
     */
    private $client;

    /**
     * Construct API client with default base path
     * and authorization
     *
     * @param string $token Rev AI access token
     */
    public function __construct($token, $config = [])
    {
        parent::__construct($config);

        if (!isset($token)) {
            throw new Exception('Access token missing');
        }

        $this->client = new Client([
            'base_uri' => 'https://api.rev.ai/speechtotext/v1/',
            'headers' => ['Authorization' => "Bearer $token"],
        ]);
    }


    /**
     * Submit a remote audio file for transcription
     *
     * @param string $fileUrl URL to remote file
     *
     * @return stdClass Rev AI Jobs API endpoint response object
     */
    public function submitAsychronousJobRemote($fileUrl)
    {
        return json_decode(
            $this->client->request(
                'POST',
                'jobs',
                ['json' => ['media_url' => $fileUrl]]
            )->getBody()->getContents()
        );
    }

    /**
     * Submit a local audio file for transcription
     *
     * @param string $file Path to local file
     *
     * @return stdClass Rev AI Jobs API endpoint response object
     */
    public function submitAsychronousJobLocal($file)
    {
        return json_decode(
            $this->client->request(
                'POST',
                'jobs',
                ['multipart' => [['name' => 'media','contents' => fopen($file, 'r')]]]
            )->getBody()->getContents()
        );
    }

    /**
     * Get transcription job status
     *
     * @param string $id Transcription job ID
     *
     * @return stdClass Rev AI Jobs API endpoint response object
     */
    public function getAsychronousJobStatus($id)
    {
        return json_decode(
            $this->client->request(
                'GET',
                "jobs/$id"
            )->getBody()->getContents()
        );
    }

    /**
     * Get transcription job result
     *
     * @param string $id Transcription job ID
     *
     * @return stdClass Rev AI Transcript API endpoint response object
     */
    public function getAsychronousJobResult($id)
    {
        return json_decode(
            $this->client->request(
                'GET',
                "jobs/$id/transcript",
                ['headers' => ['Accept' => 'application/vnd.rev.transcript.v1.0+json']]
            )->getBody()->getContents()
        );
    }
}
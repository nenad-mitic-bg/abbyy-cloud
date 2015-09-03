<?php

namespace ShoneZlo\AbbyyCloud;

use GuzzleHttp\Client;

class AbbyyClient
{

    /**
     * @var Client
     */
    private $api;

    /**
     * @param string $appId
     * @param string $password
     */
    public function __construct($appId, $password)
    {
        $this->api = new Client([
            'base_uri' => 'http://cloud.ocrsdk.com/',
            'auth' => [$appId, $password]
        ]);
    }

    /**
     * @param string $inputFilePath
     * @return string
     */
    public function performOcr($inputFilePath, $language = 'english')
    {
        $task = $this->submitImage($inputFilePath, $language);

        while (true) {
            sleep($task->getEstimatedProcessingTime());
            $task = $this->checkTask($task);

            if ($task->getResultUrl()) {
                break;
            }
        }

        $resp = (new Client())->get($task->getResultUrl());

        if ($resp->getStatusCode() === 200) {
            return $resp->getBody()->getContents();
        }

        throw new AbbyyException($resp->getBody()->getContents(), $resp->getStatusCode());
    }

    /**
     * @param string $inputFilePath
     * @param string $language
     * @return AbbyyTask
     * @throws AbbyyException
     */
    public function submitImage($inputFilePath, $language = 'english')
    {
        $options = [
            'query' => [
                'profile' => 'textExtraction',
                'imageSource' => 'photo',
                'exportFormat' => 'txt',
                'language' => $language
            ],
            'body' => fopen($inputFilePath, 'r')
        ];

        $resp = $this->api->post('processImage', $options);

        if ($resp->getStatusCode() === 200) {
            return AbbyyTask::parseXml($resp->getBody()->getContents());
        }

        throw new AbbyyException($this->getErrorMessage($resp->getBody()->getContents()), $resp->getStatusCode());
    }

    /**
     * @param AbbyyTask $task
     * @return AbbyyTask
     * @throws AbbyyException
     */
    public function checkTask(AbbyyTask $task)
    {
        $options = [
            'query' => ['taskid' => $task->getId()]
        ];

        $resp = $this->api->get('/getTaskStatus', $options);

        if ($resp->getStatusCode() === 200) {
            return AbbyyTask::parseXml($resp->getBody()->getContents());
        }

        throw new AbbyyException($this->getErrorMessage($resp->getBody()->getContents()), $resp->getStatusCode());
    }

    /**
     * @param string $xmlString
     * @return string
     */
    private function getErrorMessage($xmlString)
    {
        $xml = simplexml_load_string($response);
        return '' . $xml->message;
    }

}

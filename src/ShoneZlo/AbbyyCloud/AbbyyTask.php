<?php

namespace ShoneZlo\AbbyyCloud;

class AbbyyTask
{

    /**
     * @var string
     */
    private $id;

    /**
     * Estimated time until the task is completed (in seconds)
     * @var integer
     */
    private $estimatedProcessingTime;

    /**
     * @var string
     */
    private $resultUrl;

    public function __construct($id, $estimatedProcessingTime)
    {
        $this->id = $id;
        $this->estimatedProcessingTime = $estimatedProcessingTime;
    }

    /**
     * @param string $xmlString
     * @return AbbyyTask
     */
    public static function parseXml($xmlString)
    {
        $xml = simplexml_load_string($xmlString);
        $xt = $xml->task[0];

        if ($xt['error']) {
            throw new AbbyyException('' . $xt['error']);
        }

        switch ('' . $xt['status']) {
            case 'ProcessingFailed':
                throw new AbbyyException('ProcessingFailed');
            case 'NotEnoughCredits':
                throw new AbbyyException('NotEnoughCredits');
        }

        $task = new AbbyyTask($xt['id'] . '', intval('' . $xt['estimatedProcessingTime']));

        if (isset($xt['resultUrl'])) {
            $task->resultUrl = '' . $xt['resultUrl'];
        }

        return $task;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEstimatedProcessingTime()
    {
        return $this->estimatedProcessingTime;
    }

    public function getResultUrl()
    {
        return $this->resultUrl;
    }

}

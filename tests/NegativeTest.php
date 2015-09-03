<?php

use ShoneZlo\AbbyyCloud\AbbyyClient;

class NegativeTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException ShoneZlo\AbbyyCloud\AbbyyException
     * @expectedExceptionCode 450
     */
    public function testBadInput()
    {
        $inputFilePath = __DIR__ . '/picture_samples/textfile.jpg';
        $abbyy = new AbbyyClient(APP_NAME, APP_PASSWORD);
        $abbyy->performOcr($inputFilePath);
    }

    /**
     * @expectedException ShoneZlo\AbbyyCloud\AbbyyException
     * @expectedExceptionCode 551
     */
    public function testUnsupportedFile()
    {
        $inputFilePath = __DIR__ . '/picture_samples/plain.txt';
        $abbyy = new AbbyyClient(APP_NAME, APP_PASSWORD);
        $abbyy->performOcr($inputFilePath);
    }

}

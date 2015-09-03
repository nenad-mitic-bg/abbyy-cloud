<?php

class PositiveTest extends PHPUnit_Framework_TestCase
{

    public function testGoodImage()
    {
        $inputFilePath = __DIR__ . '/picture_samples/image.jpg';
        $abbyy = new ShoneZlo\AbbyyCloud\AbbyyClient(APP_NAME, APP_PASSWORD);
        $text = $abbyy->performOcr($inputFilePath);
        $this->assertInternalType('string', $text);
    }

}

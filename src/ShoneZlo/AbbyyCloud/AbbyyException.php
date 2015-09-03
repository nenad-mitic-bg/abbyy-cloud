<?php

namespace ShoneZlo\AbbyyCloud;

use Exception;

class AbbyyException extends Exception
{

    /**
     * @param string $xmlString
     * @param integer HTTP Error code
     * @return AbbyyException
     */
    public static function parseXml($xmlString, $code)
    {
        $xml = simplexml_load_string($xmlString);
        $ret = new AbbyyException('' . $xml->message[0], $code);
        return $ret;
    }

}

<?php

function jsonToXml($data, $rootElement = "<response/>") {
    $xml = new SimpleXMLElement($rootElement);
    arrayToXml($data, $xml);
    header("Content-Type: application/xml");
    return $xml->asXML();
}

function arrayToXml($data, &$xmlData) {
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $subnode = $xmlData->addChild(is_numeric($key) ? "item$key" : $key);
            arrayToXml($value, $subnode);
        } else {
            $xmlData->addChild(is_numeric($key) ? "item$key" : $key, htmlspecialchars($value));
        }
    }
}

?>

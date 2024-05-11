<?php


abstract class XmlSerializerBase {
    // Método para convertir datos a XML
    protected function toXml($data): string {
        $xml = new SimpleXMLElement('<root/>');
        array_walk_recursive($data, function($value, $key) use ($xml) {
            $xml->addChild($key, $value);
        });
        return $xml->asXML();
    }

    // Método para convertir XML a datos
    protected function fromXml($xmlString): array {
        $xml = simplexml_load_string($xmlString);
        $json = json_encode($xml);
        return json_decode($json, TRUE);
    }
}


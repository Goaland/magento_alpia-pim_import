<?php

namespace Goalandfrance\AlpiaImport\Helper\Api\Result;

class MappingResult extends AbstractResult
{
    /**
     * @return string[]
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string[] $value
     */
    public function setValue($value)
    {
        $mappings = array();
        if ($value["count"] > 0) {
            foreach ($value["list"] as $mappingInfo) {
                $mappings[] = ["value" => $mappingInfo["id"], "label" => $mappingInfo["name"] . " (Connector " . $mappingInfo["connector_name"] . ")"];
            }
        }

        $this->value = $mappings;
    }
}

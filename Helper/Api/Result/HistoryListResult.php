<?php

namespace Goalandfrance\AlpiaImport\Helper\Api\Result;

class HistoryListResult extends AbstractResult
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
        $history = [];
        if ($value["count"] > 0) {
            foreach ($value["list"] as $historyInfo) {
                $history[] = $historyInfo;
            }
        }

        $this->value = $history;
    }
}

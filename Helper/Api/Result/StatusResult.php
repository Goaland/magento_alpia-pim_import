<?php

namespace Goalandfrance\AlpiaImport\Helper\Api\Result;

class StatusResult extends AbstractResult
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
        $this->value = $value;
    }
}

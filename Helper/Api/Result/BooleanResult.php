<?php

namespace Goalandfrance\AlpiaImport\Helper\Api\Result;

class BooleanResult extends AbstractResult
{
    /**
     * @return string[]
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param boolean $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}

<?php

namespace Goalandfrance\AlpiaImport\Helper\Api\Result;

use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\Helper\AbstractHelper;

abstract class AbstractResult extends AbstractHelper
{

    /** @var bool Indicates if the webservice call was successful */
    private $success = false;

    /** @var string Message returned in case a problem happened */
    private $message = "";

    /** @var mixed */
    protected $value = null;

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->success;
    }

    /**
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    abstract public function getValue();

    abstract public function setValue($value);
}

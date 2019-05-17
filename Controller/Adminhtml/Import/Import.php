<?php

namespace Goalandfrance\AlpiaImport\Controller\Adminhtml\Import;

use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Controller\ResultFactory;
use \Magento\Framework\App\Config\ScopeConfigInterface;


class Import extends \Magento\Backend\App\Action
{
    protected $pageFactory;
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Goalandfrance\AlpiaImport\Helper\Api\Api
     */
    private $api;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        ScopeConfigInterface $scopeConfig
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->scopeConfig = $scopeConfig;

        $this->messageManager = $context->getMessageManager();
        $this->_redirect = $context->getRedirect();
        $this->api = $this->_objectManager->create('Goalandfrance\AlpiaImport\Helper\Api\Api');
    }

    public function execute()
    {
        $result = $this->api->export();

        if ($result->isSuccessful() && $result->getValue()) {
            $this->messageManager->addSuccessMessage(__("Your import request is queued in Alpia"));
        } else {
            $this->messageManager->addErrorMessage(__("ERROR: your request was canceled"));
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/dashboard');

        return $resultRedirect;
    }
}

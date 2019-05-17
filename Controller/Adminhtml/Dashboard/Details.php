<?php

namespace Goalandfrance\AlpiaImport\Controller\Adminhtml\Dashboard;

use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Details extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var \Goalandfrance\AlpiaImport\Helper\Api\Api
     */
    private $api;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    )
    {
        parent::__construct($context);

        $this->pageFactory = $pageFactory;
        $this->context = $context;
        $this->api = $this->_objectManager->create('Goalandfrance\AlpiaImport\Helper\Api\Api');
    }

    public function execute()
    {
        $resultPage = $this->pageFactory->create();

        $id = $this->getRequest()->getParam('id');

        $data = [
            "success" => true,
            "message" => '',
            "history_details" => []
        ];

        $version = $this->api->getVersion();
        if ($version->isSuccessful()) {
            $data['version'] = $version->getValue();
        } else {
            $data['success'] = false;
            $data['message'] = $version->getMessage();
        }

        if ($data['success']) {
            $details = $this->api->getHistoryDetails($id);
            if ($details->isSuccessful()) {
                $data['history_details'] = $details->getValue();
            } else {
                $data['success'] = false;
                $data['message'] = $details->getMessage();
            }
        }

        $resultPage->getLayout()->getBlock('dashboard_details')->setData($data);

        return $resultPage;
    }
}

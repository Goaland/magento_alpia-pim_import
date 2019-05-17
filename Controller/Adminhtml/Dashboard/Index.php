<?php

namespace Goalandfrance\AlpiaImport\Controller\Adminhtml\Dashboard;

use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
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

        $data = [
            "success" => true,
            "version" => "",
            "history_list" => "",
            "status" => "",
        ];

        $version = $this->api->getVersion();
        if ($version->isSuccessful()) {
            $data['version'] = $version->getValue();
        } else {
            $data['success'] = false;
            $data['message'] = $version->getMessage();
        }

        if ($data['success']) {
            $history = $this->api->getHistoryList();
            if ($history->isSuccessful()) {
                $data['history_list'] = $history->getValue();
            } else {
                $data['success'] = false;
                $data['message'] = $history->getMessage();
            }
        }

        if ($data['success']) {
            $countExport = $this->api->getStatus();
            if ($countExport->isSuccessful()) {
                $data['status'] = $countExport->getValue();
            } else {
                $data['success'] = false;
                $data['message'] = $countExport->getMessage();
            }
        }

//        echo '<pre>';
//        var_dump($data);
//        die();

        $resultPage->getLayout()->getBlock('dashboard_index')->setData($data);

        return $resultPage;
    }
}

<?php
namespace Goalandfrance\AlpiaImport\Helper;

use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    private $baseGoalandfranceConfigPath = 'goalandfranceAdmin/goalandfranceAlpiaImportAPIConfig/';
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);

        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    public function getApiUrl()
    {
        return $this->scopeConfig->getValue($this->baseGoalandfranceConfigPath . 'goalandfranceAlpiaImportAPIConfigUrl');
    }

    public function getApplicationKey()
    {
        return $this->scopeConfig->getValue($this->baseGoalandfranceConfigPath . 'goalandfranceAlpiaImportAPIConfigAppKey');
    }

    public function getUserKey()
    {
        return $this->scopeConfig->getValue($this->baseGoalandfranceConfigPath . 'goalandfranceAlpiaImportAPIConfigUserKey');
    }

    public function getMappingId()
    {
        return $this->scopeConfig->getValue($this->baseGoalandfranceConfigPath . 'goalandfranceAlpiaImportAPIConfigMappingId');
    }

    public function getBaseUrl()
    {
        return  $this->storeManager->getStore()->getBaseUrl();
    }
}

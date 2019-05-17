<?php

namespace Goalandfrance\AlpiaImport\Block\SystemConfig;

use Goalandfrance\AlpiaImport\Helper\Api\Api;
use Goalandfrance\AlpiaImport\Helper\Config;

class MappingIdSelectOptions extends \Magento\Config\Block\System\Config\Form\Field
{

    private $scopeConfig;

    /**
     * @var \Magento\Backend\Block\Template\Context
     */
    private $context;
    /**
     * @var Api
     */
    private $api;
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        Api $api,
        Config $config
    )
    {
        parent::__construct($context);

        $this->scopeConfig = $context->getScopeConfig();
        $this->context = $context;
        $this->api = $api;
        $this->config = $config;
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $mappingList = $this->api->getMappingList();
        if ($mappingList->isSuccessful() && count($mappingList->getValue()) > 0) {
            $options = [];
            $options[] = ["value" => "", "label" => __("Select a mapping")];
            foreach ($mappingList->getValue() as $mapping) {
                $options[] = $mapping;
            }

            $html = $this->getLayout()->createBlock('Magento\Framework\View\Element\Html\Select')
                ->setName("groups[goalandfranceAlpiaImportAPIConfig][fields][goalandfranceAlpiaImportAPIConfigMappingId][value]")
                ->setId("goalandfranceAdmin_goalandfranceAlpiaImportAPIConfig_goalandfranceAlpiaImportAPIConfigMappingId")
                ->setTitle(__("Connector mapping id"))
                ->setValue($this->config->getMappingId())
                ->setOptions($options)
                ->setExtraParams('data-validate="{\'validate-select\':true}"')
                ->getHtml();
        } else {
            if ($mappingList->isSuccessful()) {
                $html = "<p class='note'>" . __("No mapping found. You must create a connector, an export mapping and associate an export in Alpia before using this extension.") . "</p>";
            } else {
                $html = "<p class='note'>" . __("The configuration of Alpia API is not complete or invalid. Please fill or verify the Url and Keys configurations.") . "</p>";
            }
        }

        return $html;
    }
}
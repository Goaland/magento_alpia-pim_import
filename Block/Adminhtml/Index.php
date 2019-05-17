<?php

namespace Goalandfrance\AlpiaImport\Block\Adminhtml;

use Magento\Backend\Block\Template;

class Index extends Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getConfigUrl() {
        return $this->getUrl('adminhtml/system_config/edit/section/goalandfranceAdmin');
    }

}

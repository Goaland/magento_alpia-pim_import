<?php

namespace Goalandfrance\AlpiaImport\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Framework\Exception\NoSuchEntityException;

class Details extends Template
{
    /**
     * @var Template\Context
     */
    private $context;
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->context = $context;
        $this->productRepository = $productRepository;
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getSkuLink($sku)
    {
        if (strlen(trim($sku)) == 0) {
            return;
        }

        if ($this->_authorization->isAllowed('Magento_Products::actions_edit')) {
            try {
                $product = $this->productRepository->get($sku);
                if ($product !== null) {
                    return '<a href="' . $this->escapeUrl($this->getUrl('catalog/product/edit', ['id' => $product->getId()])) . '">' . $this->escapeHtml($sku) . '</a>';
                }
            } catch (NoSuchEntityException $ex) {
                //normal case, nothing to do
            } catch (\Exception $ex) {
                //normal case, nothing to do
            }
        }
        return $sku;
    }

    public function getAlpiaPimLink($id)
    {
        $alpiaLoginUrl = $this->getData('history_details')['alpia_login_url'];

        return '<a href="' . $this->escapeUrl($alpiaLoginUrl . '?recoIdx=' . $id) . '" target="_blank" title="' . __('Show in Alpia PIM') . '">' . $id . '</a>';
    }

    public function getConfigUrl()
    {
        return $this->getUrl('adminhtml/system_config/edit/section/goalandfranceAdmin');
    }

}

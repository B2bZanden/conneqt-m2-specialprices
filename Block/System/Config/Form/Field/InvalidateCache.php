<?php
namespace Conneqt\SpecialPrices\Block\System\Config\Form\Field;;

class InvalidateCache extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var \Conneqt\SpecialPrices\Helper\Cache
     */
    private $cache;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Conneqt\SpecialPrices\Helper\Cache $cache,
        array $data = [],
        \Magento\Framework\View\Helper\SecureHtmlRenderer $secureRenderer = null
    ) {
        parent::__construct($context, $data, $secureRenderer);

        $this->cache = $cache;
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        /** @var \Magento\Backend\Block\Widget\Button $buttonBlock  */
        $buttonBlock = $this->getForm()->getLayout()->createBlock(\Magento\Backend\Block\Widget\Button::class);

        $data = [
            'id' => 'invalidate_conneqt_price_cache',
            'label' => $this->getLabel(),
            'onclick' => "setLocation('" . $this->getInvalidateCacheUrl() . "')",
            'after_html' => $this->cache->isEnabled() ? '<p class="note"><span>' . __('Currently cached price results: %1', count($this->cache->getKeys('conneqt_sp'))) . '</span></p>' : ''
        ];

        $html = $buttonBlock->setData($data)->toHtml();
        return $html;
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    private function getLabel()
    {
        return  __('Invalidate Cache');
    }

    /**
     * @param array $params
     *
     * @return string
     */
    private function getInvalidateCacheUrl()
    {
        return $this->getUrl('conneqt_specialprices/cache/invalidate');
    }
}

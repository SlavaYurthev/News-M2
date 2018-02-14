<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Block\Listing;

class View extends \Magento\Framework\View\Element\Template {
	protected $_registry;
	protected $_filter;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\Registry $registry,
		\Magento\Cms\Model\Template\FilterProvider $filter
	){
		$this->_registry = $registry;
		$this->_filter = $filter;
		parent::__construct($context);
	}
	public function format($html) {
		return $this->_filter->getBlockFilter()
			->setStoreId(
				$this->_storeManager->getStore()->getId()
			)->filter($html);
	}
	public function getItem($key = false){
		if($key){
			return $this->_registry->registry('item')->getData($key);
		}
		return $this->_registry->registry('item');
	}
	protected function _prepareLayout(){
		$this->pageConfig->getTitle()->set($this->getItem('title'));
		if($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')){
			$breadcrumbs->addCrumb(
				'home',
				[
					'title' => __('Home'),
					'label' => __('Home'),
					'link' => $this->getUrl('')
				]
			)->addCrumb(
				'news',
				[
					'title' => __('News'),
					'label' => __('News'),
					'link' => $this->getUrl('news')
				]
			);
		}
		parent::_prepareLayout();
	}
}
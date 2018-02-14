<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Block;

class Listing extends \Magento\Framework\View\Element\Template {
	protected $_collection;
	protected $_filter;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\SY\News\Model\Item $model,
		\Magento\Cms\Model\Template\FilterProvider $filter
	){
		$this->_collection = $model->getCollection();
		$this->_filter = $filter;
		parent::__construct($context);
	}
	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
	public function getCollection(){
		$page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
		$pageSize = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 10;
		$this->_collection->addFieldToFilter('active', true);
		$this->_collection->setPageSize($pageSize);
		$this->_collection->setCurPage($page);
		$this->_collection->setOrder('created_at', 'desc');
		return $this->_collection;
	}
	protected function _prepareLayout(){
		$this->pageConfig->getTitle()->set(__('News'));
		if($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')){
			$breadcrumbs->addCrumb(
				'home',
				[
					'title' => __('Home'),
					'label' => __('Home'),
					'link' => $this->getUrl('')
				]
			);
		}
		$pager = $this->getLayout()->createBlock(
			'Magento\Theme\Block\Html\Pager',
			'news.listing.pager'
		)->setAvailableLimit(
			[10=>10,15=>15,20=>20]
		)->setShowPerPage(false)->setCollection(
			$this->getCollection()
		);
		$this->setChild('pager', $pager);
		$this->getCollection()->load();
		parent::_prepareLayout();
	}
	public function format($html) {
		return $this->_filter->getBlockFilter()
			->setStoreId(
				$this->_storeManager->getStore()->getId()
			)->filter($html);
	}
}
<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Block;

class LatestNews extends \Magento\Framework\View\Element\Template {
	protected $_collectionFactory;
	public $_template = 'SY_News::latest.phtml';
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\SY\News\Model\ResourceModel\Item\CollectionFactory $collectionFactory
	){
		$this->_collectionFactory = $collectionFactory;
		parent::__construct($context);
	}
	public function getCollection(){
		$collection = $this->_collectionFactory->create();
		$collection->addFieldToFilter('active', true);
		$collection->setOrder('created_at', 'desc');
		$collection->getSelect()->limit($this->getData('limit'));
		return $collection;
	}
}
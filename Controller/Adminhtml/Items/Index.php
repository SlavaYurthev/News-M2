<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Controller\Adminhtml\Items;

use \Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Index extends Action {
	protected $_resultPageFactory;
	protected $_resultPage;
	public function __construct(Context $context, PageFactory $resultPageFactory){
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
	}
	public function execute(){
		$this->_setPageData();
		return $this->getResultPage();
	}
	protected function _isAllowed(){
		return $this->_authorization->isAllowed('SY_News::items');
	}
	public function getResultPage(){
		if (is_null($this->_resultPage)){
			$this->_resultPage = $this->_resultPageFactory->create();
		}
		return $this->_resultPage;
	}
	protected function _setPageData(){
		$resultPage = $this->getResultPage();
		$resultPage->setActiveMenu('SY_News::items');
		$resultPage->getConfig()->getTitle()->prepend((__('Items')));
		$resultPage->addBreadcrumb(__('News'), __('Items'));
		return $this;
	}
}
<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Controller\Index;

use Magento\Framework\App\Action\Action;

class View extends Action {
	protected $_coreRegistry = null;
	protected $resultPageFactory;
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\Registry $registry
	) {
		$this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry = $registry;
		parent::__construct($context);
	}
	public function execute() {
		$id = $this->getRequest()->getParam('id');
		$model = $this->_objectManager->create('SY\News\Model\Item');
		$helper = $this->_objectManager->get('SY\News\Helper\Data');
		$storeManager = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface');
		if($id && $helper->getConfigValue('general/active', $storeManager->getStore()->getData('store_id')) == "1"){
			$model->load($id);
			if(!$model->getId()){
				$this->_forward('index', 'noroute', 'cms');
			}
			else{
				$urlInterface = $this->_objectManager->get('Magento\Framework\UrlInterface');
				if($urlInterface->getCurrentUrl() != $model->getUrl()){
					$this->_forward('index', 'noroute', 'cms');
				}
				else{
					$this->_coreRegistry->register('item', $model);
					return $this->resultFactory->create(
							\Magento\Framework\Controller\ResultFactory::TYPE_PAGE
						);
				}
			}
		}
		else{
			$this->_forward('index', 'noroute', 'cms');
		}
	}
}
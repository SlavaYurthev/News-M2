<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\Filesystem\DirectoryList;
use SY\News\Helper\Data as Helper;

class Item extends AbstractModel {
	protected $urlInterface;
	protected $helper;
	protected $storeManager;
	protected $assetRepository;
	protected $directoryList;
	public function __construct(
		Context $context,
		Registry $registry,
		UrlInterface $urlInterface,
		StoreManagerInterface $storeManager,
		Repository $assetRepository,
		DirectoryList $directoryList,
		Helper $helper
		){
		$this->urlInterface = $urlInterface;
		$this->helper = $helper;
		$this->storeManager = $storeManager;
		$this->assetRepository = $assetRepository;
		$this->directoryList = $directoryList;
		parent::__construct($context, $registry);
	}
	protected function _construct() {
		$this->_init('SY\News\Model\ResourceModel\Item');
	}
	public function afterSave(){
		if((bool)$this->getData('url_key') === false){
			$url_key = $this->_getUrlKeyByString($this->getData('title'));
			if((bool)$url_key !== false){
				$this->setData('url_key', $url_key);
				$this->save();
			}
		}
	}
	public function hasImage(){
		if((bool)$this->getData('image') !== false &&
			is_file($this->directoryList->getRoot().$this->getData('image'))){
			return true;
		}
	}
	public function getImageUrl(){
		if($this->hasImage()){
			return $this->getData('image');
		}
		else{
			return $this->assetRepository->createAsset(
				'SY_News::images/no-image-large.png', 
				['area' => 'frontend']
			)->getUrl();
		}
	}
	private function _getUrlKeyByString($string = ''){
		try {
			$string = preg_replace(
				"/[^a-zA-Z0-9 ]+$/", 
				"", 
				preg_replace(
					"/\s+/", 
					"-", 
					strtolower($string)
				)
			);
		} catch (\Exception $e) {}
		$string = ltrim($string, "-");
		$string = rtrim($string, "-");
		$string .= $this->helper->getConfigValue('items/format');
		return $string;
	}
	public function getUrl(){
		$url = $this->urlInterface->getUrl(
			'news/index/view', 
			[
				'id' => $this->getData('id')
			]
		);
		if($this->helper->getConfigValue(
				'items/url_key', 
				$this->storeManager->getStore()->getData('store_id')
			) == "1" && (bool)$this->getData('url_key') !== false){
			$url = rtrim($url, '/').'/';
			$url .= $this->getData('url_key');
		}
		return $url;
	}
}
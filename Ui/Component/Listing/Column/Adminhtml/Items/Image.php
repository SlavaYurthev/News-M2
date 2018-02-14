<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Ui\Component\Listing\Column\Adminhtml\Items;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\Filesystem\DirectoryList;

class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
	protected $storeManager;
	protected $assetRepository;
	protected $directoryList;
	public function __construct(
		ContextInterface $context,
		UiComponentFactory $uiComponentFactory,
		StoreManagerInterface $storeManager,
		array $components = [],
		Repository $assetRepository,
		DirectoryList $directoryList,
		array $data = []
	) {
		$this->storeManager = $storeManager;
		$this->assetRepository = $assetRepository;
		$this->directoryList = $directoryList;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}
	public function prepareDataSource(array $dataSource) {
		if(isset($dataSource['data']['items'])) {
			foreach($dataSource['data']['items'] as & $item) {
				if($item) {
					$item['image_src'] = $this->assetRepository->createAsset(
							'SY_News::images/no-image-small.png', 
							['area' => 'adminhtml']
						)->getUrl();
					if(isset($item['image']) && 
						(bool)$item['image'] !== false && 
						is_file($this->directoryList->getRoot().$item['image'])){
						$item['image_src'] = $item['image'];
					}
				}
			}
		}
		return $dataSource;
	}
}
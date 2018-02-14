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

class Active extends \Magento\Ui\Component\Listing\Columns\Column
{
	protected $storeManager;
	public function __construct(
		ContextInterface $context,
		UiComponentFactory $uiComponentFactory,
		StoreManagerInterface $storeManager,
		array $components = [],
		array $data = []
	) {
		$this->storeManager = $storeManager;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}
	public function prepareDataSource(array $dataSource) {
		if(isset($dataSource['data']['items'])) {
			foreach($dataSource['data']['items'] as & $item) {
				if($item) {
					$item['active'] = ($item['active'] == 1 ? __('Yes') : __('No'));
				}
			}
		}
		return $dataSource;
	}
}
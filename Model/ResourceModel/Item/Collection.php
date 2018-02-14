<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Model\ResourceModel\Item;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {
	protected function _construct() {
		$this->_init(
			'SY\News\Model\Item',
			'SY\News\Model\ResourceModel\Item'
		);
	}
}
<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Item extends AbstractDb {
	protected function _construct() {
		$this->_init('sy_news_item', 'id');
	}
}
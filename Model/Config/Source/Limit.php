<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Model\Config\Source;

class Limit implements \Magento\Framework\Option\ArrayInterface {
	public function toOptionArray(){
		return [
			['value' => 1, 'label' => 1],
			['value' => 3, 'label' => 3],
			['value' => 5, 'label' => 5],
			['value' => 10, 'label' => 10],
			['value' => 15, 'label' => 15],
			['value' => 20, 'label' => 20]
		];
	}
}
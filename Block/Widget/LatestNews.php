<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Block\Widget;

class LatestNews extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface {
	protected function _toHtml(){
		return $this->getLayout()->createBlock(
			\SY\News\Block\LatestNews::class,
			'',
			[
				'data' => [
					'limit' => $this->getData('limit')
				]
			]
		)->toHtml();
	}
}
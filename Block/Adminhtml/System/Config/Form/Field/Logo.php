<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Block\Adminhtml\System\Config\Form\Field;

use \Magento\Framework\Data\Form\Element\AbstractElement;

class Logo extends \Magento\Config\Block\System\Config\Form\Field {
	protected function _getElementHtml(AbstractElement $element){
		return '<p style="padding-top:7px"><img src="'.$this->getViewFileUrl('SY_News::images/logo.png').'"></p>';
	}
}
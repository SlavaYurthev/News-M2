<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Block\Adminhtml\Items\Edit\Tab;
 
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Filesystem\DirectoryList;
 
class General extends Generic implements TabInterface {
	protected $_wysiwygConfig;
	protected $_directoryList;
	public function __construct(
		Context $context,
		Registry $registry,
		FormFactory $formFactory,
		Config $wysiwygConfig,
		DirectoryList $_directoryList,
		array $data = []
	) {
		$this->_directoryList = $_directoryList;
		$this->_wysiwygConfig = $wysiwygConfig;
		parent::__construct($context, $registry, $formFactory, $data);
	}
	protected function _prepareForm(){
		$model = $this->_coreRegistry->registry('item');
		$form = $this->_formFactory->create();
 
		$fieldset = $form->addFieldset(
			'base_fieldset',
			['legend' => __('General')]
		);
 
		if ($model->getId()) {
			$fieldset->addField(
				'id',
				'hidden',
				['name' => 'id']
			);
		}
		if($model->getData('image') && is_file($this->_directoryList->getRoot().$model->getData('image'))){
			$fieldset->addField(
				'thumbnail',
				'note',
				[
					'name' => 'thumbnail',
					'label'	=> __(''),
					'required' => false,
					'note' => '<div>
						<a href="'.$model->getData('image').'" target="_blank">
							<img src="'.$model->getData('image').'" style="max-height:100px" />
						</a>
					</div>'
				]
			);
		}
		$fieldset->addField(
			'image',
			'file',
			[
				'name' => 'image',
				'label'	=> __('Image'),
				'required' => false,
				'note' => 'Allow image type: jpg, jpeg, png'
			]
		);
		$fieldset->addField(
			'title',
			'text',
			[
				'name' => 'title',
				'label'	=> __('Title'),
				'required' => true
			]
		);
		$fieldset->addField(
			'description',
			'editor',
			[
				'name' => 'description',
				'label'	=> __('Description'),
				'required' => true,
				'style' => 'height: 15em; width: 100%;',
				'config' => $this->_wysiwygConfig->getConfig()
			]
		);
		$fieldset->addField(
			'text',
			'editor',
			[
				'name' => 'text',
				'label' => __('Text'),
				'required' => true,
				'style' => 'height: 15em; width: 100%;',
				'config' => $this->_wysiwygConfig->getConfig()
			]
		);
		$fieldset->addField(
			'url_key',
			'text',
			[
				'name' => 'url_key',
				'label'	=> __('Url Key'),
				'required' => false,
				'class' => 'validate-identifier',
				'note' => __('Leave empty to auto-generate')
			]
		);
		$fieldset->addField(
			'active',
			'select',
			[
				'name' => 'active',
				'label'	=> __('Active'),
				'required' => true,
				'values' => [
					['value'=>"1",'label'=>__('Yes')],
					['value'=>"0",'label'=>__('No')]
				]
			]
		);
		$data = $model->getData();
		$form->setValues($data);
		$this->setForm($form);
 
		return parent::_prepareForm();
	}
	public function getTabLabel(){
		return __('Item');
	}
	public function getTabTitle(){
		return __('Item');
	}
	public function canShowTab(){
		return true;
	}
	public function isHidden(){
		return false;
	}
}
<?php
/**
 * News
 * 
 * @author Slava Yurthev
 */
namespace SY\News\Ui\Component\Listing\Column\Adminhtml\Items;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class PostActions extends Column
{
    const EDIT = 'sy_news/items/edit';
    const DELETE = 'sy_news/items/delete';
    protected $urlBuilder;
    private $editUrl;
    private $deleteUrl;
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::EDIT,
        $deleteUrl = self::DELETE
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        $this->deleteUrl = $deleteUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    public function prepareDataSource(array $dataSource){
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl($this->deleteUrl, ['id' => $item['id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete'),
                            'message' => __('Are you sure you wan\'t to delete record?')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
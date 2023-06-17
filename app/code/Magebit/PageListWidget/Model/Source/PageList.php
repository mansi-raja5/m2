<?php

namespace Magebit\PageListWidget\Model\Source;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as PageCollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class PageList
 * @package Magebit\PageListWidget\Model\Source
 */
class PageList implements OptionSourceInterface
{
    /**
     * @var PageCollectionFactory
     */
    protected $pageCollectionFactory;

    /**
     * PageList constructor.
     * @param PageCollectionFactory $pageCollectionFactory
     */
    public function __construct(PageCollectionFactory $pageCollectionFactory)
    {
        $this->pageCollectionFactory = $pageCollectionFactory;
    }

    /**
     * Get options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $pageCollection = $this->pageCollectionFactory->create();
        $pageCollection->addFieldToSelect(['page_id', 'title']);
        foreach ($pageCollection as $page) {
            $options[] = [
                'value' => $page->getId(),
                'label' => $page->getTitle(),
            ];
        }
        return $options;
    }

    /**
     * Get all CMS pages
     *
     * @return \Magento\Cms\Model\ResourceModel\Page\Collection
     */
    public function getAllPages()
    {
        $pageCollection = $this->pageCollectionFactory->create();
        return $pageCollection;
    }

    /**
     * Get selected CMS pages
     *
     * @param array $selectedPageIds
     * @return \Magento\Cms\Model\ResourceModel\Page\Collection
     */
    public function getSelectedPages($selectedPageIds)
    {
        $pageCollection = $this->pageCollectionFactory->create();
        $pageCollection->addFieldToFilter('page_id', ['in' => $selectedPageIds]);
        return $pageCollection;
    }
}

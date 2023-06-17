<?php

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magebit\PageListWidget\Model\Source\PageList as PageListModel;
use Magento\Cms\Model\PageFactory;

class PageListWidget extends Template implements BlockInterface
{
    protected $_template = 'widget/page_list.phtml';

    const DISPLAY_MODE_ALL = 'all';
    const DISPLAY_MODE_SPECIFIC = 'specific';

    /**
     * @var FilterProvider
     */
    protected $_filterProvider;

    /**
     * @var PageListModel
     */
    protected $pageListModel;

    /**
     * @var PageFactory
     */
    protected $_cmsPageModelFactory;

    /**
     * PageListWidget constructor.
     * @param Template\Context $context
     * @param FilterProvider $filterProvider
     * @param PageListModel $pageListModel
     * @param PageFactory $cmsPageModelFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        FilterProvider $filterProvider,
        PageListModel $pageListModel,
        PageFactory $cmsPageModelFactory,
        array $data = []
    ) {
        $this->_filterProvider = $filterProvider;
        $this->pageListModel = $pageListModel;
        $this->_cmsPageModelFactory = $cmsPageModelFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get the title option value.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * Get the display mode option value.
     *
     * @return string|null
     */
    public function getDisplayMode()
    {
        return $this->getData('display_mode');
    }

    /**
     * Get the selected pages option value.
     *
     * @return array
     */
    public function getSelectedPages()
    {
        $selectedPages = $this->getData('selected_pages');
        if (!is_array($selectedPages)) {
            $selectedPages = explode(',', $selectedPages);
        }
        return $selectedPages;
    }

    /**
     * Get the list of CMS pages based on the display mode.
     *
     * @return array
     */
    public function getCmsPages()
    {
        $displayMode = $this->getDisplayMode();
        if ($displayMode === self::DISPLAY_MODE_ALL) {
            $cmsPages = $this->_getAllCmsPages();
        } elseif ($displayMode === self::DISPLAY_MODE_SPECIFIC) {
            $cmsPages = $this->_getSelectedCmsPages();
        } else {
            $cmsPages = [];
        }
        return $cmsPages;
    }

    /**
     * Get all CMS pages.
     *
     * @return array
     */
    protected function _getAllCmsPages()
    {
        $allPages = [];
        $cmsPages = $this->pageListModel->getAllPages();
        foreach ($cmsPages as $cmsPage) {
            $allPages[] = [
                'id' => $cmsPage->getId(),
                'title' => $this->_filterProvider->getPageFilter()->filter($cmsPage->getTitle()),
            ];
        }
        return $allPages;
    }

    /**
     * Get the selected CMS pages.
     *
     * @return array
     */
    protected function _getSelectedCmsPages()
    {
        $selectedPages = [];
        $selectedPageIds = $this->getSelectedPages();
        $cmsPages = $this->pageListModel->getSelectedPages($selectedPageIds);
        foreach ($cmsPages as $cmsPage) {
            $selectedPages[] = [
                'id' => $cmsPage->getId(),
                'title' => $this->_filterProvider->getPageFilter()->filter($cmsPage->getTitle()),
            ];
        }
        return $selectedPages;
    }

    /**
     * Retrieve the CMS page model instance.
     *
     * @return \Magento\Cms\Model\Page
     */
    protected function _getCmsPageModel()
    {
        return $this->_cmsPageModelFactory->create();
    }
}

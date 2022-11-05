<?php
declare(strict_types=1);

namespace Am\Blog\Controller\Adminhtml\Category;

use Am\Blog\Api\Data\CategoryInterface;
use Am\Blog\Controller\Adminhtml\AbstractCategory;
use Am\Blog\Model\CategoryFactory;
use Am\Blog\Model\ResourceModel\Category\CategoryRepository;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

class Edit extends AbstractCategory
{
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    public function __construct(
        CategoryFactory $categoryFactory,
        CategoryRepository $categoryRepository,
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $categoryId = (int)$this->getRequest()->getParam(CategoryInterface::CATEGORY_ID);

        if ($categoryId) {
            try {
                $category = $this->categoryRepository->getById($categoryId);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addExceptionMessage(
                    $exception,
                    __('This category no longer exists.')
                );
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/');

                return $resultRedirect;
            }
            if (!$category->getId()) {
                $this->messageManager->addErrorMessage(__('This Category no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $category = $this->categoryFactory->create();
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu(AbstractCategory::ADMIN_RESOURCE)
            ->getConfig()->getTitle()->prepend(
                $categoryId
                    ? __('Edit "%1" category', $category->getTitle())
                    : __('New Category')
            );

        return $resultPage;
    }
}

<?php
declare(strict_types=1);

namespace Am\Blog\Controller\Adminhtml\Category;

use Am\Blog\Model\ResourceModel\Category\CategoryRepository;
use Am\Blog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\Store;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var Filter
     */
    private $filter;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        CategoryRepository $categoryRepository,
        Filter $filter
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->categoryRepository = $categoryRepository;
        $this->filter = $filter;

        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $successCount = 0;
            $collection = $this->filter->getCollection($this->collectionFactory->create(
                ['storeId' => Store::DEFAULT_STORE_ID]
            ));
            foreach ($collection->getAllIds() as $categoryId) {
                $this->categoryRepository->deleteById((int)$categoryId);
                $successCount++;
            }
            $this->messageManager->addSuccessMessage(
                __('A total of %1 category(s) have been deleted.', $successCount)
            );
        } catch (LocalizedException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage(
                $exception,
                __('Something went wrong while delete the items.')
            );
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}

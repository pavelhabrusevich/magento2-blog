<?php
declare(strict_types=1);

namespace Am\Blog\Controller\Adminhtml\Post;

use Am\Blog\Model\ResourceModel\Post\CollectionFactory;
use Am\Blog\Model\ResourceModel\Post\PostRepository;
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
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var Filter
     */
    private $filter;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        PostRepository $postRepository,
        Filter $filter
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->postRepository = $postRepository;
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
            foreach ($collection->getAllIds() as $postId) {
                $this->postRepository->deleteById((int)$postId);
                $successCount++;
            }
            $this->messageManager->addSuccessMessage(
                __('A total of %1 post(s) have been deleted.', $successCount)
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

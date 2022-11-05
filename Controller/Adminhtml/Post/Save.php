<?php
declare(strict_types=1);

namespace Am\Blog\Controller\Adminhtml\Post;

use Am\Blog\Api\Data\PostInterface;
use Am\Blog\Api\PostRepositoryInterface;
use Am\Blog\Controller\Adminhtml\AbstractPost;
use Am\Blog\Model\PostFactory as PostFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends AbstractPost
{
    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    public function __construct(
        Context $context,
        PostFactory $postFactory,
        DataPersistorInterface $dataPersistor,
        PostRepositoryInterface $postRepository,
        DataObjectHelper $dataObjectHelper,
    ) {
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->dataPersistor = $dataPersistor;
        $this->dataObjectHelper = $dataObjectHelper;

        parent::__construct($context);
    }

    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data = $this->getRequest()->getPostValue()) {
            try {
                $postId = isset($data[PostInterface::POST_ID]) ? (int)$data[PostInterface::POST_ID] : false;
                $model = $postId
                    ? $this->postRepository->getById($postId)
                    : $this->postFactory->create();

                $this->dataObjectHelper->populateWithArray($model, $data, PostInterface::POST_ID);
                $this->postRepository->save($model);
                $this->dataPersistor->clear(self::DATA_PERSISTOR_KEY);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

                if ($this->getRequest()->getParam('back') == 'edit') {
                    return $this->resultRedirectFactory->create()->setPath(
                        '*/*/edit',
                        [PostInterface::POST_ID => $model->getId()]
                    );
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the post'));
            }
            $this->dataPersistor->set(PostInterface::POST_ID, $data);
            $postId = isset($data[PostInterface::POST_ID]) ? (int)$data[PostInterface::POST_ID] : false;
            if ($postId) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $postId, '_current' => true]);
            }

            return $resultRedirect->setPath('*/*/new', ['_current' => true]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}

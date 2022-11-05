<?php
declare(strict_types=1);

namespace Am\Blog\Controller\Adminhtml\Post;

use Am\Blog\Model\PostFactory;
use Am\Blog\Model\ResourceModel\Post\PostRepository;
use Am\Blog\Controller\Adminhtml\AbstractPost;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Am\Blog\Api\Data\PostInterface;

class Edit extends AbstractPost
{
    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    public function __construct(
        PostFactory $postFactory,
        PostRepository $postRepository,
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam(PostInterface::POST_ID);

        if ($id) {
            $model = $this->postRepository->getById($id);
//            edit
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Post no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        return $this->resultPageFactory->create();
    }
}

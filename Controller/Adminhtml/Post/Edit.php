<?php
declare(strict_types=1);

namespace Am\Blog\Controller\Adminhtml\Post;

use Am\Blog\Api\Data\PostInterface;
use Am\Blog\Controller\Adminhtml\AbstractPost;
use Am\Blog\Model\PostFactory;
use Am\Blog\Model\ResourceModel\Post\PostRepository;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

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
        $postId = (int)$this->getRequest()->getParam(PostInterface::POST_ID);

        if ($postId) {
            try {
                $post = $this->postRepository->getById($postId);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addExceptionMessage(
                    $exception,
                    __('This post no longer exists.')
                );
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/');

                return $resultRedirect;
            }
            if (!$post->getId()) {
                $this->messageManager->addErrorMessage(__('This Post no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $post = $this->postFactory->create();
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage
            ->setActiveMenu(AbstractPost::ADMIN_RESOURCE)
            ->getConfig()->getTitle()->prepend(
                $postId
                    ? __('Edit "%1" post', $post->getTitle())
                    : __('New Post')
            );

        return $resultPage;
    }
}

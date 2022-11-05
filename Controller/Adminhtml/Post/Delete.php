<?php
declare(strict_types=1);

namespace Am\Blog\Controller\Adminhtml\Post;

use Am\Blog\Api\Data\PostInterface;
use Am\Blog\Controller\Adminhtml\AbstractPost;
use Am\Blog\Model\ResourceModel\Post\PostRepository;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Delete extends AbstractPost
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        Context $context,
        PostRepository $postRepository,
        LoggerInterface $logger
    ) {
        $this->postRepository = $postRepository;
        $this->logger = $logger;

        parent::__construct($context);
    }

    public function execute()
    {
        if ($postId = (int)$this->getRequest()->getParam(PostInterface::POST_ID)) {
            try {
                $this->postRepository->deleteById($postId);
                $this->messageManager->addSuccessMessage(__('You deleted the post.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('We can\'t delete post right now. Please review the log and try again.')
                );
                $this->logger->critical($e);
            }
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}

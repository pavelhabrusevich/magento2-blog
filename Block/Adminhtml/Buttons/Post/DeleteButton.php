<?php
declare(strict_types=1);

namespace Am\Blog\Block\Adminhtml\Buttons\Post;

use Am\Blog\Api\Data\PostInterface;
use Am\Blog\Block\Adminhtml\Buttons\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        $data = [];
        if ($this->getPostId()) {
            $data = [
                'label' => __('Delete Post'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/post/delete', [PostInterface::POST_ID => $this->getPostId()]);
    }
}

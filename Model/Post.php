<?php
declare(strict_types=1);

namespace Am\Blog\Model;

use Am\Blog\Api\Data\PostInterface;
use Am\Blog\Model\ResourceModel\Post\Post as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel implements PostInterface
{
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getPostId(): int
    {
        return (int)$this->getData(PostInterface::POST_ID);
    }

    public function setPostId(int $id): PostInterface
    {
        return $this->setData(PostInterface::POST_ID, $id);
    }

    public function getStatus(): int
    {
        return (int)$this->getData(PostInterface::POST_STATUS);
    }

    public function setStatus(int $status): PostInterface
    {
        return $this->setData(PostInterface::POST_STATUS, $status);
    }

    public function getTitle(): string
    {
        return (string)$this->getData(PostInterface::POST_TITLE);
    }

    public function setTitle(string $title): PostInterface
    {
        return $this->setData(PostInterface::POST_TITLE, $title);
    }

    public function getUrlKey(): string
    {
        return (string)$this->getData(PostInterface::POST_URL_KEY);
    }

    public function setUrlKey(string $urlKey): PostInterface
    {
        return $this->setData(PostInterface::POST_URL_KEY, $urlKey);
    }

    public function getContent(): string
    {
        return (string)$this->getData(PostInterface::POST_CONTENT);
    }

    public function setContent(string $content): PostInterface
    {
        return $this->setData(PostInterface::POST_CONTENT, $content);
    }

    public function getCreatedAt(): string
    {
        return (string)$this->getData(PostInterface::POST_CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): PostInterface
    {
        return $this->setData(PostInterface::POST_CREATED_AT, $createdAt);
    }
}

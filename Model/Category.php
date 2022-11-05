<?php
declare(strict_types=1);

namespace Am\Blog\Model;

use Am\Blog\Api\Data\CategoryInterface;
use Am\Blog\Model\ResourceModel\Category\Category as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Category extends AbstractModel implements CategoryInterface
{
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getCategoryId(): int
    {
        return (int)$this->getData(CategoryInterface::CATEGORY_ID);
    }

    public function setCategoryId(int $id): CategoryInterface
    {
        return $this->setData(CategoryInterface::CATEGORY_ID, $id);
    }

    public function getStatus(): int
    {
        return (int)$this->getData(CategoryInterface::CATEGORY_STATUS);
    }

    public function setStatus(int $status): CategoryInterface
    {
        return $this->setData(CategoryInterface::CATEGORY_STATUS, $status);
    }

    public function getTitle(): string
    {
        return (string)$this->getData(CategoryInterface::CATEGORY_TITLE);
    }

    public function setTitle(string $title): CategoryInterface
    {
        return $this->setData(CategoryInterface::CATEGORY_TITLE, $title);
    }

    public function getUrlKey(): string
    {
        return (string)$this->getData(CategoryInterface::CATEGORY_URL_KEY);
    }

    public function setUrlKey(string $urlKey): CategoryInterface
    {
        return $this->setData(CategoryInterface::CATEGORY_URL_KEY, $urlKey);
    }

    public function getContent(): string
    {
        return (string)$this->getData(CategoryInterface::CATEGORY_CONTENT);
    }

    public function setContent(string $content): CategoryInterface
    {
        return $this->setData(CategoryInterface::CATEGORY_CONTENT, $content);
    }

    public function getCreatedAt(): string
    {
        return (string)$this->getData(CategoryInterface::CATEGORY_CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): CategoryInterface
    {
        return $this->setData(CategoryInterface::CATEGORY_CREATED_AT, $createdAt);
    }

    public function getUpdatedAt(): string
    {
        return (string)$this->getData(CategoryInterface::CATEGORY_UPDATED_AT);
    }

    public function setUpdatedAt(string $updatedAt): CategoryInterface
    {
        return $this->setData(CategoryInterface::CATEGORY_UPDATED_AT, $updatedAt);
    }
}

<?php
declare(strict_types=1);

namespace Am\Blog\Api\Data;

interface CategoryInterface
{
    public const CATEGORY_ID = 'category_id';
    public const CATEGORY_TITLE = 'title';
    public const CATEGORY_STATUS = 'status';
    public const CATEGORY_URL_KEY = 'url_key';
    public const CATEGORY_CONTENT = 'description';
    public const CATEGORY_CREATED_AT = 'created_at';
    public const CATEGORY_UPDATED_AT = 'updated_at';
//    public const CATEGORY_VIEWS = 'views';
//    public const CATEGORY_THUMBNAIL = 'category_thumbnail';

    /**
     * @return int
     */
    public function getCategoryId(): int;

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setCategoryId(int $id): CategoryInterface;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus(int $status): CategoryInterface;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): CategoryInterface;

    /**
     * @return string
     */
    public function getUrlKey(): string;

    /**
     * @param string $urlKey
     *
     * @return $this
     */
    public function setUrlKey(string $urlKey): CategoryInterface;

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): CategoryInterface;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(string $createdAt): CategoryInterface;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): CategoryInterface;
}

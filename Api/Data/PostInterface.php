<?php
declare(strict_types=1);

namespace Am\Blog\Api\Data;

interface PostInterface
{
    public const POST_ID = 'post_id';
    public const POST_STATUS = 'status';
    public const POST_TITLE = 'title';
    public const POST_URL_KEY = 'url_key';
    public const POST_CONTENT = 'content';
    public const POST_CREATED_AT = 'created_at';
//    public const POST_VIEWS = 'views';
//    public const POST_THUMBNAIL = 'post_thumbnail';

    /**
     * @return int
     */
    public function getPostId(): int;

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setPostId(int $id): PostInterface;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus(int $status): PostInterface;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): PostInterface;

    /**
     * @return string
     */
    public function getUrlKey(): string;

    /**
     * @param string $urlKey
     *
     * @return $this
     */
    public function setUrlKey(string $urlKey): PostInterface;

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): PostInterface;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(string $createdAt): PostInterface;
}

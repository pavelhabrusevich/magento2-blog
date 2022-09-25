<?php
declare(strict_types=1);

namespace Am\Blog\Model\ResourceModel\Post;

use Am\Blog\Api\Data\PostInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    public const POST_TABLE = 'am_blog_posts';

    protected function _construct()
    {
        $this->_init(self::POST_TABLE, PostInterface::POST_ID);
    }
}

<?php
declare(strict_types=1);

namespace Am\Blog\Model\ResourceModel\Category;

use Am\Blog\Api\Data\CategoryInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Category extends AbstractDb
{
    public const CATEGORY_TABLE = 'am_blog_categories';

    protected function _construct()
    {
        $this->_init(self::CATEGORY_TABLE, CategoryInterface::CATEGORY_ID);
    }
}

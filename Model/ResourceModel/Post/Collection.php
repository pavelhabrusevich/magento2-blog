<?php
declare(strict_types=1);

namespace Am\Blog\Model\ResourceModel\Post;

use Am\Blog\Model\Post as Model;
use Am\Blog\Model\ResourceModel\Post\Post as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}

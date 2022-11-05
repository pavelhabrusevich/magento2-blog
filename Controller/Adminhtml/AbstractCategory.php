<?php
declare(strict_types=1);

namespace Am\Blog\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class AbstractCategory extends Action
{
    public const ADMIN_RESOURCE = 'Am_Blog::amblog_category';
    public const DATA_PERSISTOR_KEY = 'am_blog_category';
}

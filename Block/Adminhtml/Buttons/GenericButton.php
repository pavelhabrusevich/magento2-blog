<?php
declare(strict_types=1);

namespace Am\Blog\Block\Adminhtml\Buttons;

use Am\Blog\Api\Data\CategoryInterface;
use Am\Blog\Api\Data\PostInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

class GenericButton
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var RequestInterface
     */
    protected $request;

    public function __construct(
        Context $context
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->request = $context->getRequest();
    }

    public function getUrl($route = '', $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    public function getPostId(): int
    {
        return (int)$this->request->getParam(PostInterface::POST_ID);
    }

    public function getCategoryId(): int
    {
        return (int)$this->request->getParam(CategoryInterface::CATEGORY_ID);
    }
}

<?php
declare(strict_types=1);

namespace Am\Blog\Model\Post\DataProvider;

use Am\Blog\Api\Data\PostInterface;
use Am\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use Am\Blog\Controller\Adminhtml\AbstractPost;

class Form extends AbstractDataProvider
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        PostCollectionFactory $collectionFactory,
        RequestInterface $request,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData(): array
    {
        $formData = $this->dataPersistor->get(AbstractPost::DATA_PERSISTOR_KEY);
        if (!empty($formData)
            && is_array($formData)
        ) {
            $postId = $formData[PostInterface::POST_ID] ?? null;
            $this->dataPersistor->clear(AbstractPost::DATA_PERSISTOR_KEY);
            $postData = $formData;
        } else {
            $postId = $this->request->getParam($this->getRequestFieldName());
            $post = $this->getCollection()
                ->addFieldToFilter(PostInterface::POST_ID, $postId)
                ->getFirstItem();
            if (!$post) {
                $post = $this->collection->getNewEmptyItem();
            }
            $postData = $post->getData();
        }
        $data[$postId] = $postData;

        return $data;
    }
}
